<?php
/**
 * Webino (http://zf.webino.org/)
 *
 * @copyright   Copyright (c) 2012 Peter Bačinský (http://www.bacinsky.sk/)
 * @license     New BSD License
 * @package     WebinoDraw
 */

namespace Webino\Draw\Helper;

use Webino\Draw\NodeList;
use Webino\View\Helper\VarTranslator;
use Zend\View\Helper\AbstractHelper;

/**
 * @category    Webino
 * @package     WebinoDraw
 * @subpackage  DrawHelper
 * @author      Peter Bačinský <peter@bacinsky.sk>
 */
class Element extends AbstractHelper
{
    private $vars = array();

    /**
     *
     * @var VarTranslator
     */
    private $varTranslator;

    public function getVars()
    {
        return $this->vars;
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
        return $this;
    }

    public function getVarTranslator()
    {
        return $this->varTranslator;
    }

    public function setVarTranslator(VarTranslator $varTranslator)
    {
        $this->varTranslator = $varTranslator;
        return $this;
    }

    public function __invoke(NodeList $nodes, array $spec)
    {
        $varTranslator = $this->getVarTranslator();
        $spec          = $varTranslator($spec, $this->getVars());

        // remove node by xpath
        !array_key_exists('remove', $spec) or
            $nodes->remove($spec['remove']);
        
        // replace
        !array_key_exists('replace', $spec) or
            $this->replace($nodes, $spec);
        
        // text value
        !array_key_exists('value', $spec) or
            $nodes->setValue($spec['value']);
        
        // xhtml code
        !array_key_exists('html', $spec) or
            $this->setHtml($nodes, $spec);
        
        // attribs
        !array_key_exists('attribs', $spec) or
            $this->setAttribs($nodes, $spec);
        
        // onEmpty
        !array_key_exists('onEmpty', $spec) or
            $this->onEmpty($nodes, $spec['onEmpty']);
    }

    public function onEmpty(NodeList $nodes, array $spec)
    {
        foreach ($nodes as $node) {
            if (!empty($node->nodeValue) 
                || is_numeric($node->nodeValue)
            ) continue;
            
            $this(new NodeList(array($node)), $spec);
        }
    }
    
    public function replace(NodeList $nodes, array $spec)
    {
        foreach ($nodes as $node) {
            $nodes = new NodeList(array($node));
            $nodes->replace($spec['replace']);
            $subspec = $spec;
            unset($subspec['replace']);
            $this($nodes, $subspec);
        }
    }
    
    public function setHtml(NodeList $nodes, array $spec)
    {
        $varTranslator = $this->getVarTranslator();
        $preSet        = null;
        
        $var = $varTranslator->key2Var('html');
        if (false !== strpos($spec['html'], $var)) {
            $preSet = function(\DOMElement $node, $value)
                use ($varTranslator, $var) 
            {
                if (empty($spec['var']['default'][$var])) {
                    $translation[$var] = null;
                } else {
                    $translation[$var] = $spec['var']['default'][$var];
                }
                foreach ($node->childNodes as $child) {
                    $translation[$var].= $child->ownerDocument->saveXML($child);
                }
                return $varTranslator->translateString(
                    $value, $translation
                );
            };
        }
        
        $nodes->setHtml($spec['html'], $preSet);
    }
    
    public function setAttribs(NodeList $nodes, array $spec)
    {
        $varTranslator = $this->getVarTranslator();
        
        $nodes->setAttribs(
            $spec['attribs'], 
            function(\DOMElement $node, $value) use ($varTranslator) {
                if ($node->attributes) {
                    if (empty($spec['var']['default'])) {
                        $translation = array();
                    } else {
                        $translation = $spec['var']['default'];
                    }
                    foreach ($node->attributes as $attrib) {
                        $translation[
                            $varTranslator->key2Var($attrib->name)
                        ] = $attrib->value;
                    }
                    $value = $varTranslator->translateString(
                        $value, $translation
                    );
                    if ($varTranslator->stringHasVar($value)) {
                        $value = null;
                    }
                }
                return $value;
            }
        );
    }
}
