<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Form\View\Helper;

use Zend\Form\Element;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormElement as BaseFormElement;
use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\I18n\Translator\TranslatorAwareTrait;

/**
 * Class FormElement
 */
class FormElement extends BaseFormElement implements
    TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    /**
     * View helper service name
     */
    const SERVICE = 'webinodrawformelement';

    /**
     * {@inheritdoc}
     */
    protected function renderHelper($name, ElementInterface $element)
    {
        // view helper option
        $viewHelper = $element->getOption('view_helper');
        empty($viewHelper) and $viewHelper = $name;

        $helper = $this->getView()->plugin($viewHelper);
        $helper->setTranslatorEnabled($this->isTranslatorEnabled());
        $helper->setTranslatorTextDomain($this->getTranslatorTextDomain());

        return $helper($element);
    }
}
