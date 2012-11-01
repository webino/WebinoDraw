<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_View
 */

namespace WebinoDraw\View\Helper;

/**
 * @category    Webino
 * @package     WebinoDraw_View
 * @subpackage  Helper
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
            empty($spec['var']['default']) or
                $varTranslator->translationDefaults(
                    $translation,
                    $varTranslator->array2translation($spec['var']['default'])
                );

            $translation = array_merge(
                $translation,
                $helper->getNodeTranslation($node)
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
        $varTranslator = $this->getVarTranslator();
        $translation   = array();
        $var           = $varTranslator->key2var('html');

        return function (
            \DOMElement $node,
            $value
        ) use (
            $subject,
            $spec,
            $varTranslator,
            $translation,
            $var
        ) {
            empty($spec['var']['default']) or
                $varTranslator->translationDefaults(
                    $translation,
                    $varTranslator->array2translation($spec['var']['default'])
                );

            if (false !== strpos($subject, $var)) {
                if ($node->childNodes->length
                  || !array_key_exists($var, $translation)
                ) {
                    $translation[$var] = null;
                }
                foreach ($node->childNodes as $child) {
                    $html = trim($child->ownerDocument->saveXML($child));
                    empty($html) or $translation[$var].= $html;
                }
            }
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
            empty($spec['var']['default']) or
                $varTranslator->translationDefaults(
                    $translation,
                    $varTranslator->array2translation($spec['var']['default'])
                );

            $translation = array_merge(
                $translation,
                $helper->getNodeTranslation($node)
            );
            $value = $varTranslator->translateString(
                $value,
                $translation
            );
            if ($varTranslator->stringHasVar($value)) {
                $value = null;
            }
            return $value;
        };
    }
}
