<?php
/**
 * Webino (http://zf.webino.org/)
 *
 * @copyright   Copyright (c) 2012 Peter Bačinský (http://www.bacinsky.sk/)
 * @license     New BSD License
 * @package     WebinoDraw
 */

namespace WebinoDraw\View\Helper;

use WebinoDraw\Dom\NodeList;
use WebinoDraw\View\Helper\VarTranslator;
use Zend\View\Helper\AbstractHelper;

/**
 * @category    Webino
 * @package     WebinoDraw
 * @subpackage  DrawHelper
 * @author      Peter Bačinský <peter@bacinsky.sk>
 */
class DrawElement extends AbstractHelper
{
    /**
     *
     * @var VarTranslator
     */
    private $varTranslator;
    
    private $vars = array();

    public function __construct(VarTranslator $varTranslator) {
        $this->varTranslator = $varTranslator;
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
        return $this;
    }

    public function __invoke(NodeList $nodes, array $spec)
    {
        $spec = $this->varTranslator->__invoke($spec, $this->getVars());

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
        $varTranslator = $this->varTranslator;
        $render        = array();
        
        if (!empty($spec['render'])) {
            foreach ($spec['render'] as $key => $value) {
                $render[$varTranslator->key2Var($key)]
                    = $this->view->render($value);
            }
        }
        $var = $varTranslator->key2Var('html');
        $preSet = function(\DOMElement $node, $value)
            use ($varTranslator, $spec, $render, $var) 
        {
            $translation = $render;
            if (false !== strpos($spec['html'], $var)) {
                if (empty($spec['var']['default'][$var])) {
                    $translation[$var] = null;
                } else {
                    $translation[$var] = $spec['var']['default'][$var];
                }
                foreach ($node->childNodes as $child) {
                    $translation[$var].= $child->ownerDocument->saveXML($child);
                }
            }
            return $varTranslator->translateString(
                $value, $translation
            );
        };
        
        $nodes->setHtml($spec['html'], $preSet);
    }
    
    public function setAttribs(NodeList $nodes, array $spec)
    {
        $varTranslator = $this->varTranslator;
        
        $nodes->setAttribs(
            $spec['attribs'], 
            function(\DOMElement $node, $value) use ($varTranslator, $spec) {
                if ($node->attributes) {
                    if (empty($spec['var']['default'])) {
                        $translation = array();
                    } else {
                        $translation = $spec['var']['default'];
                    }
                    foreach ($node->attributes as $attrib) {
                        $translation[$attrib->name] = $attrib->value;
                    }
                    if (!empty($spec['var']['helper'])) {
                        $helperSpec = $varTranslator(
                            $spec['var']['helper'], $translation
                        );
                        $translation = $varTranslator->applyHelper(
                            $translation, $helperSpec
                        );
                    }
                    $value = $varTranslator->translateString(
                        $value, $varTranslator->array2Translation($translation)
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
