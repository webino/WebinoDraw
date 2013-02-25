<?php

namespace WebinoDraw\Form\View\Helper;

use Zend\Form\Element;
use Zend\Form\ElementInterface;
use Zend\I18n\View\Helper\AbstractTranslatorHelper as BaseAbstractHelper;

class MagicFormElement extends BaseAbstractHelper
{
    /**
     * Render an element
     *
     * Introspects the element type and attributes to determine which
     * helper to utilize when rendering.
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function resolveHelper(ElementInterface $element)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return null;
        }

        if ($element instanceof Element\Button) {
            return $renderer->plugin('form_button');
        }

        if ($element instanceof Element\Captcha) {
            return $renderer->plugin('form_captcha');
        }

        if ($element instanceof Element\Csrf) {
            return $renderer->plugin('form_hidden');
        }

        if ($element instanceof Element\Collection) {
            return $renderer->plugin('form_collection');
        }

        if ($element instanceof Element\DateTimeSelect) {
            return $renderer->plugin('form_date_time_select');
        }

        if ($element instanceof Element\DateSelect) {
            return $renderer->plugin('form_date_select');
        }

        if ($element instanceof Element\MonthSelect) {
            return $renderer->plugin('form_month_select');
        }

        $type = $element->getAttribute('type');

        switch ($type) {
            case 'datetime':
                return $renderer->plugin('form_date_time');

            case 'datetime-local':
                return $renderer->plugin('form_date_time_local');

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
                return $renderer->plugin('form_' . $type);
        }

        return $helper;
    }

    public function render(ElementInterface $element)
    {
        $helper = $this->resolveHelper($element);
        if (empty($helper)) {
            return '';
        }

        $helper->setTranslatorEnabled($this->isTranslatorEnabled());
        $helper->setTranslatorTextDomain($this->getTranslatorTextDomain());

        return $helper($element);
    }

    /**
     * Invoke helper as function
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
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
