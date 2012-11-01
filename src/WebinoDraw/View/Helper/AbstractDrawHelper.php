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

use WebinoDraw\Stdlib\VarTranslator;
use Zend\View\Helper\AbstractHelper;

/**
 * @category    Webino
 * @package     WebinoDraw_View
 * @subpackage  Helper
 */
abstract class AbstractDrawHelper extends AbstractHelper implements DrawHelperInterface
{
    /**
     * @var array
     */
    private $vars = array();

    /**
     * @var WebinoDraw\View\Helper\VarTranslator
     */
    private $varTranslator;

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->vars;
    }

    /**
     * @param  array $vars
     * @return \WebinoDraw\View\Helper\AbstractDrawHelper
     */
    public function setVars(array $vars)
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * @param  \WebinoDraw\Stdlib\VarTranslator $varTranslator
     * @return \WebinoDraw\View\Helper\AbstractDrawHelper
     */
    public function setVarTranslator(VarTranslator $varTranslator)
    {
        $this->varTranslator = $varTranslator;
        return $this;
    }

    /**
     * @return WebinoDraw\Stdlib\VarTranslator
     */
    public function getVarTranslator()
    {
        if (!$this->varTranslator) {
            $this->setVarTranslator(new VarTranslator);
        }
        return $this->varTranslator;
    }

    /**
     * Get array translation from DOM node.
     *
     * @param  \DOMElement $node
     * @return array
     */
    public function nodeTranslation(\DOMElement $node)
    {
        $translation = array();

        if (!empty($node->nodeValue)) {
            $translation['nodeValue'] = $node->nodeValue;
        }

        foreach ($node->attributes as $attr) {
            $translation[$attr->name] = $attr->value;
        }

        return $translation;
    }
}
