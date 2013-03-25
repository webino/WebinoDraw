<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw;

use Zend\Form\Form;
use Zend\Form\FormInterface;

/**
 *
 */
class DrawFormEvent extends DrawEvent
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        if (null === $this->form) {
            $this->setForm(new Form);
        }
        return $this->form;
    }

    /**
     * @param FormInterface $form
     * @return DrawFormEvent
     */
    public function setForm(FormInterface $form)
    {
        $this->setParam('form', $form);
        $this->form = $form;
        return $this;
    }
}
