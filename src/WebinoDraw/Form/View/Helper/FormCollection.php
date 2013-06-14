<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\Element\Collection as CollectionElement;
use Zend\Form\FieldsetInterface;
use Zend\Form\View\Helper\FormCollection as BaseFormCollection;

/**
 * Extended Zend FormCollection with support of sorting elements
 */
class FormCollection extends BaseFormCollection
{
    /**
     * Render a collection by iterating through all fieldsets and elements
     *
     * Supports elements order.
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $markup           = '';
        $templateMarkup   = '';
        $escapeHtmlHelper = $this->getEscapeHtmlHelper();
        $elementHelper    = $this->getElementHelper();
        $fieldsetHelper   = $this->getFieldsetHelper();

        if ($element instanceof CollectionElement && $element->shouldCreateTemplate()) {
            $templateMarkup = $this->renderTemplate($element);
        }

        // Sort elements by order
        $elements = array();
        $index = 0;
        foreach ($element->getIterator() as $elementOrFieldset) {
            $index++;

            $order = $elementOrFieldset->getOption('order');
            $elementIndex = (null !== $order ? $order : $index);

            $elements[$elementIndex][] = $elementOrFieldset;
        }
        ksort($elements);

        // Render sorted elements
        foreach ($elements as $elementGroup) {
            foreach ($elementGroup as $elementOrFieldset) {
                if ($elementOrFieldset instanceof FieldsetInterface) {
                    $markup .= $fieldsetHelper($elementOrFieldset);
                } elseif ($elementOrFieldset instanceof ElementInterface) {
                    $markup .= $elementHelper($elementOrFieldset);
                }
            }
        }

        // If $templateMarkup is not empty, use it for simplify adding new element in JavaScript
        if (!empty($templateMarkup)) {
            $markup .= $templateMarkup;
        }

        // Every collection is wrapped by a fieldset if needed
        if ($this->shouldWrap) {
            $label = $element->getLabel();

            if (!empty($label)) {

                if (null !== ($translator = $this->getTranslator())) {
                    $label = $translator->translate(
                            $label, $this->getTranslatorTextDomain()
                    );
                }

                $label = $escapeHtmlHelper($label);

                $markup = sprintf(
                    '<fieldset><legend>%s</legend>%s</fieldset>',
                    $label,
                    $markup
                );
            }
        }

        return $markup;
    }
}
