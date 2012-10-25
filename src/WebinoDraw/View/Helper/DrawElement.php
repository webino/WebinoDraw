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
use WebinoDraw\Stdlib\VarTranslator;
use Zend\View\Helper\AbstractHelper;

/**
 * WebinoDraw helper used for DOM base modifications.
 *
 * Custom options accepted by this component:
 *
 * <pre>
 * 'var' => array(
 *   'default' => array(
 *     'customvar' => 'customval',      // if variable is empty use default value
 *   ),
 *   'helper' => array(
 *     'varname' => array(
 *       'viewhelper' => array(
 *         'method' => array(array()),  // helper method params
 *       ),
 *       'function' => array(array()),  // function params
 *     ),
 *   ),
 * ),
 * </pre>
 *
 * By those custom options this component call view helpers
 * and functions over those {$variable}. This is useful because
 * you can for example generate whole head link and many more.
 *
 * @category    Webino
 * @package     WebinoDraw
 * @subpackage  DrawHelper
 * @author      Peter Bačinský <peter@bacinsky.sk>
 */
class DrawElement extends AbstractHelper implements DrawHelperInterface
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
     * @return \WebinoDraw\View\Helper\DrawElement
     */
    public function setVars(array $vars)
    {
        $this->vars = $vars;
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
     * @param  \WebinoDraw\Stdlib\VarTranslator $varTranslator
     * @return \WebinoDraw\View\Helper\DrawElement
     */
    public function setVarTranslator(VarTranslator $varTranslator)
    {
        $this->varTranslator = $varTranslator;
        return $this;
    }

    /**
     *
     * @param \WebinoDraw\Dom\NodeList $nodes
     * @param array $spec
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $varTranslator = $this->getVarTranslator();
        $translation   = $this->getVars();

        // default variables
        empty($spec['var']['default']) or
            $varTranslator->translationDefaults(
                $translation,
                $spec['var']['default']
            );

        // variable helpers
        empty($spec['var']['helper']) or
            $varTranslator->applyHelper(
                $translation,
                $spec['var']['helper'],
                $this->view->getHelperPluginManager()
            );

        $varTranslator->translate(
            $spec,
            $varTranslator->array2Translation($translation)
        );

        unset($translation);

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
            ) {
                continue;
            }
            $this(new NodeList(array($node)), $spec);
        }
    }

    public function replace(NodeList $nodes, array $spec)
    {
        foreach ($nodes as $node) {
            $nodes   = new NodeList(array($node));
            $nodes->replace($spec['replace']);
            $subspec = $spec;
            unset($subspec['replace']);
            $this($nodes, $subspec);
        }
    }

    public function setHtml(NodeList $nodes, array $spec)
    {
        $varTranslator = $this->getVarTranslator();
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
        $helperPluginManager = $this->view->getHelperPluginManager();
        $varTranslator       = $this->getVarTranslator();

        $nodes->setAttribs(
            $spec['attribs'],
            function(\DOMElement $node, $value)
                use ($varTranslator, $spec, $helperPluginManager)
            {
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
                        $helperSpec = $spec['var']['helper'];
                        $varTranslator->translate(
                            $helperSpec,
                            $varTranslator->array2Translation($translation)
                        );

                        $varTranslator->applyHelper(
                            $translation,
                            $helperSpec,
                            $helperPluginManager
                        );
                    }
                    $value = $varTranslator->translateString(
                        $value,
                        $varTranslator->array2Translation($translation)
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
