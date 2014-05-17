<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Form\View\Helper;

use Zend\Form\Element;
use Zend\Form\ElementInterface;
use Zend\I18n\View\Helper\AbstractTranslatorHelper;

/**
 *
 */
class FormElement extends AbstractTranslatorHelper
{
    /**
     * Returns an element
     *
     * Introspects the element type and attributes to determine which
     * helper to utilize when rendering.
     *
     * @param ElementInterface $element
     * @return string
     */
    public function resolveHelper(ElementInterface $element)
    {
        $view = $this->getView();
        if (!method_exists($view, 'plugin')) {
            throw new \RuntimeException('Expected injected View');
        }

        // View helper option
        $viewHelper = $element->getOption('view_helper');
        if ($viewHelper) {
            return $view->plugin($viewHelper);
        }

        // Determine the view helper
        if ($element instanceof Element\Button) {
            return $view->plugin('form_button');
        }

        if ($element instanceof Element\Captcha) {
            return $view->plugin('form_captcha');
        }

        if ($element instanceof Element\Csrf) {
            return $view->plugin('form_hidden');
        }

        if ($element instanceof Element\Collection) {
            return $view->plugin('form_collection');
        }

        if ($element instanceof Element\DateTimeSelect) {
            return $view->plugin('form_date_time_select');
        }

        if ($element instanceof Element\DateSelect) {
            return $view->plugin('form_date_select');
        }

        if ($element instanceof Element\MonthSelect) {
            return $view->plugin('form_month_select');
        }

        $type = $element->getAttribute('type');

        switch ($type) {
            case 'datetime':
                return $view->plugin('form_date_time');

            case 'datetime-local':
                return $view->plugin('form_date_time_local');

            case 'checkbox':
            case 'color':
            case 'date':
            case 'email':
            case 'file':
            case 'hidden':
            case 'image':
            case 'month':
            case 'multi_checkbox':
            case 'number':
            case 'password':
            case 'radio':
            case 'range':
            case 'reset':
            case 'search':
            case 'select':
            case 'submit':
            case 'tel':
            case 'text':
            case 'textarea':
            case 'time':
            case 'url':
            case 'week':
                return $view->plugin('form_' . $type);
        }

        throw new \OutOfRangeException(
            sprintf(
                'Unknown element `%s` type `%s` of `%s`',
                $element->getName(),
                $type,
                get_class($element)
            )
        );
    }

    /**
     * @param ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $helper = $this->resolveHelper($element);
        $helper->setTranslatorEnabled($this->isTranslatorEnabled());
        $helper->setTranslatorTextDomain($this->getTranslatorTextDomain());

        return $helper($element);
    }

    /**
     * Invoke helper as function
     *
     * Proxies to {@link render()}.
     *
     * @param ElementInterface|null $element
     * @return string|FormElement
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (empty($element)) {
            return $this;
        }
        return $this->render($element);
    }
}
