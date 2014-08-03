<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw\Helper;

use DOMAttr as DomAttr;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\VarTranslator\VarTranslator;
use WebinoDraw\Exception\RuntimeException;
use Zend\View\Helper\ServerUrl;
use Zend\View\Helper\BasePath;

/**
 * Draw helper used for prepend relative URL with basePath
 */
class Absolutize extends AbstractHelper
{
    /**
     * @var VarTranslator
     */
    protected $varTranslator;

    /**
     * @var ServerUrl
     */
    protected $serverUrl;

    /**
     * @var BasePath
     */
    protected $basePath;

    /**
     * @param VarTranslator $varTranslator
     * @param ServerUrl $serverUrl
     * @param BasePath $basePath
     */
    public function __construct(VarTranslator $varTranslator, ServerUrl $serverUrl, BasePath $basePath)
    {
        $this->varTranslator = $varTranslator;
        $this->serverUrl     = $serverUrl;
        $this->basePath      = $basePath;
    }

    /**
     * @param NodeList $nodes
     */
    public function drawNodes(NodeList $nodes)
    {
        $spec = $this->getSpec();
        $translation = $this->cloneTranslationPrototype($this->getVars());
        $this->varTranslator->apply($translation, $spec);

        $translationVars = $translation->getVarTranslation();
        $basePath        = $this->basePath->__invoke();
        $serverUrl       = $this->resolveServerUrl($spec);

        foreach ($nodes as $node) {
            if (!($node instanceof DomAttr)) {
                throw new RuntimeException('Expected DOMAttr for spec ' . print_r($spec, true));
            }

            $nodeValue = $node->nodeValue;
            $translationVars->translate($nodeValue);
            $node->nodeValue = $serverUrl . $this->removeDotSegments($basePath . '/' . ltrim($nodeValue, '/'));
        }
    }

    /**
     * @param array $spec
     * @return string
     */
    private function resolveServerUrl(array $spec)
    {
        if (!array_key_exists('serverUrl', $spec)) {
            return '';
        }
        if (true === $spec['serverUrl']) {
            return $this->serverUrl->__invoke();
        }

        return (string) $spec['serverUrl'];
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
    private function removeDotSegments($path)
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
