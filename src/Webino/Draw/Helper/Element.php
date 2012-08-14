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
        !array_key_exists('remove', $spec) or $nodes->remove($spec['remove']);
        // replace
        !array_key_exists('replace', $spec) or $this->replace($nodes, $spec);
        // text value
        !array_key_exists('value', $spec) or $nodes->setValue($spec['value']);
        // xhtml code
        !array_key_exists('html', $spec) or $nodes->setHtml($spec['html']);
        // attribs
        !array_key_exists('attribs', $spec) or $nodes->setAttribs($spec['attribs']);
        // onEmpty
        !array_key_exists('onEmpty', $spec) or $this->onEmpty($nodes, $spec['onEmpty']);
    }

    public function onEmpty(NodeList $nodes, array $spec)
    {
        foreach ($nodes as $node) {
            if (!empty($node->nodeValue) || is_numeric($node->nodeValue)) continue;
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
}
