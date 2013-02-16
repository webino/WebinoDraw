<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk/)
 * @license     New BSD License
 * @package     WebinoDraw\View
 */

namespace WebinoDraw\View\Helper;

use Zend\Filter\StaticFilter;

/**
 * @category    Webino
 * @package     WebinoDraw\View
 * @subpackage  Helper
 * @author      Peter Bačinský <peter@bacinsky.sk>
 */
abstract class AbstractDrawElement extends AbstractDrawHelper
{
    /**
     * Return callable to set node value.
     *
     * @param  array $spec
     * @return type
     */
    protected function valuePreSet(array $spec)
    {
        $translation   = array();
        $varTranslator = $this->getVarTranslator();
        $helper        = $this;

        return function (
            \DOMElement $node,
            $value
        ) use (
            $helper,
            $spec,
            $translation,
            $varTranslator
        ) {

            $nodeTranslation = $helper->nodeTranslation($node);

            empty($spec['var']['default']) or
                $varTranslator->translationDefaults(
                    $nodeTranslation,
                    $spec['var']['default']
                );

            $helper->applyVarTranslator($nodeTranslation, $spec);

            $translation = array_merge(
                $translation,
                $varTranslator->array2translation($nodeTranslation)
            );

            return $varTranslator->translateString($value, $translation);
        };
    }

    /**
     * Return callable to set node HTML value.
     *
     * @param  type $subject
     * @param  array $spec
     * @return type
     */
    protected function htmlPreSet($subject, array $spec)
    {
        $translation   = array();
        $varTranslator = $this->getVarTranslator();
        $helper        = $this;

        return function (
            \DOMElement $node,
            $value
        ) use (
            $helper,
            $subject,
            $spec,
            $varTranslator,
            $translation
        ) {
            $nodeTranslation = $helper->nodeTranslation($node);

            empty($spec['var']['default']) or
                $varTranslator->translationDefaults(
                    $nodeTranslation,
                    $spec['var']['default']
                );

            if (false !== strpos($subject, 'html')) {
                if ($node->childNodes->length
                  || !array_key_exists('html', $translation)
                ) {
                    $nodeTranslation['html'] = null;
                }
                foreach ($node->childNodes as $child) {
                    $html = trim($child->ownerDocument->saveXML($child));
                    empty($html) or $nodeTranslation['html'].= $html;
                }
            }

            $helper->applyVarTranslator($nodeTranslation, $spec);

            $translation = array_merge(
                $translation,
                $varTranslator->array2translation($nodeTranslation)
            );

            return $varTranslator->translateString($value, $translation);
        };
    }

    /**
     * Return callable to set node attributes.
     *
     * @param  array $spec
     * @return type
     */
    protected function attribsPreSet(array $spec)
    {
        $translation   = array();
        $varTranslator = $this->getVarTranslator();
        $helper        = $this;

        return function (
            \DOMElement $node,
            $value
        ) use (
            $helper,
            $spec,
            $translation,
            $varTranslator
        ) {
            $nodeTranslation = $helper->nodeTranslation($node);

            empty($spec['var']['default']) or
                $varTranslator->translationDefaults(
                    $nodeTranslation,
                    $spec['var']['default']
                );

            $helper->applyVarTranslator($nodeTranslation, $spec);

            $translation = array_merge(
                $translation,
                $varTranslator->array2translation($nodeTranslation)
            );

            $value = $varTranslator->translateString($value, $translation);

            if ($varTranslator->stringHasVar($value)) {
                $value = null;
            }
            return $value;
        };
    }

    /**
     * Apply varTranslator on translation.
     *
     * @param array $translation
     * @param array $spec
     */
    public function applyVarTranslator(array &$translation, array $spec)
    {
        $varTranslator = $this->getVarTranslator();

        empty($spec['var']['filter']['pre']) or
            $varTranslator->applyFilter(
                $translation,
                $spec['var']['filter']['pre'],
                StaticFilter::getPluginManager()
            );

        empty($spec['var']['helper']) or
            $varTranslator->applyHelper(
                $translation,
                $spec['var']['helper'],
                $this->view->getHelperPluginManager()
            );

        empty($spec['var']['filter']['post']) or
            $varTranslator->applyFilter(
                $translation,
                $spec['var']['filter']['post'],
                StaticFilter::getPluginManager()
            );
    }
}
