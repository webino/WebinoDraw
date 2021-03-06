<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Factory\HelperFactory;

use WebinoDraw\Draw\Helper\Form;
use WebinoDraw\Form\View\Helper\FormRow;
use WebinoDraw\Instructions\InstructionsRenderer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class FormFactory
 */
class FormFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $drawHelpers
     * @return Form
     */
    public function createService(ServiceLocatorInterface $drawHelpers)
    {
        $services    = $drawHelpers->getServiceLocator();
        $viewHelpers = $services->get('ViewHelperManager');
        $formRow     = $viewHelpers->get(FormRow::SERVICE);

        $formCollection = clone $viewHelpers->get('FormCollection');
        $formCollection->setDefaultElementHelper(FormRow::SERVICE);

        $form = new Form(
            $services,
            $formRow,
            $formRow->getElementHelper(),
            $viewHelpers->get('FormElementErrors'),
            $formCollection,
            $viewHelpers->get('Url'),
            $services->get(InstructionsRenderer::class)
        );

        $form->setEventManager($services->get('EventManager'));
        return $form;
    }
}
