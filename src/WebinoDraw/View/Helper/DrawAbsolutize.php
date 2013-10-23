<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Helper;

use WebinoDraw\Dom\NodeList;
use WebinoDraw\Exception\RuntimeException;

/**
 * Draw helper used for prepend relative URL with basePath
 */
class DrawAbsolutize extends AbstractDrawElement
{
    /**
     * Default condition for the locator
     */
    const LOCATOR_CONDITION = '[not(starts-with(., "http")) and not(starts-with(., "#")) and not(starts-with(., "?")) and not(starts-with(., "/")) and not(starts-with(., "mailto:")) and not(starts-with(., "javascript:")) and not(../@data-webino-draw-absolutize="no")]';

    /**
     * The default locator of attributes to absolutize
     *
     * @return array
     */
    public static function getDefaultLocator()
    {
        return array(
            'src'    => 'xpath=//@src' . self::LOCATOR_CONDITION,
            'href'   => 'xpath=//@href' . self::LOCATOR_CONDITION,
            'action' => 'xpath=//@action' . self::LOCATOR_CONDITION,
        );
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $translation = $this->cloneTranslationPrototype($this->getVars());
        $this->applyVarTranslator($translation, $spec);

        $varTranslator   = $this->getVarTranslator();
        $translationVars = $varTranslator->makeVarKeys($translation);
        $basePath        = $this->view->basePath();

        foreach ($nodes as $node) {

            if (!($node instanceof \DOMAttr)) {
                throw new RuntimeException(
                    'Expected DOMAttr for spec ' . print_r($spec, true)
                );
            }

            $nodeValue = $node->nodeValue;
            $varTranslator->translate(
                $nodeValue,
                $translationVars
            );

            $node->nodeValue = $this->removeDotSegments(
                $basePath . '/' . $nodeValue
            );
        }
    }

    /**
     * Removes dots as described in RFC 3986, section 5.2.4
     *
     * Taken from the PEAR Net_URL2, cos don't want to make a dependency.
     *
     * @link http://pear.php.net/package/Net_URL2/ PEAR package
     * @param string $path a path
     * @return string a path
     */
    public function removeDotSegments($path)
    {
        $output = '';

        // Make sure not to be trapped in an infinite loop due to a bug in this
        // method
        $j = 0;
        while ($path && $j++ < 100) {
            if (substr($path, 0, 2) === './') {
                // Step 2.A
                $path = substr($path, 2);
            } elseif (substr($path, 0, 3) === '../') {
                // Step 2.A
                $path = substr($path, 3);
            } elseif (substr($path, 0, 3) === '/./' || $path === '/.') {
                // Step 2.B
                $path = '/' . substr($path, 3);
            } elseif (substr($path, 0, 4) === '/../' || $path === '/..') {
                // Step 2.C
                $path   = '/' . substr($path, 4);
                $i      = strrpos($output, '/');
                $output = $i === false ? '' : substr($output, 0, $i);
            } elseif ($path === '.' || $path === '..') {
                // Step 2.D
                $path = '';
            } else {
                // Step 2.E
                $i = strpos($path, '/');
                if ($i === 0) {
                    $i = strpos($path, '/', 1);
                }
                if ($i === false) {
                    $i = strlen($path);
                }
                $output.= substr($path, 0, $i);
                $path = substr($path, $i);
            }
        }

        return $output;
    }
}
