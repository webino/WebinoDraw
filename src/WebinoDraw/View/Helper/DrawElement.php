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

use WebinoDraw\Dom\NodeList;

/**
 * Draw helper used for DOM base modifications.
 *
 * Custom options accepted by this component:
 *
 * <pre>
 * 'value'   => 'customtext',
 * 'html'    => '&lt;customxhtml/&gt;',
 * 'replace' => '&lt;customxhtml/&gt;',
 * 'remove'  => array(
 *   'query' => array(
 *     '.css selector',
 *   ),
 *   'xpath' => array(
 *     '//xpath',
 *   ),
 * ),
 * 'trigger' => array(
 *   'event.name',
 * ),
 * 'attribs' => array(
 *   'attribname' => 'customattrib',
 * ),
 * 'onEmpty' => array(
 *   // same options as normal
 * ),
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
 * @package     WebinoDraw_View
 * @subpackage  Helper
 */
class DrawElement extends AbstractDrawHelper
{
    private function getValuePreSet(array $spec)
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

    private function getHtmlPreSet($subject, array $spec)
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

    private function getAttribsPreSet(array $spec)
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

    /**
     *
     * @param \WebinoDraw\Dom\NodeList $nodes
     * @param array $spec
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $varTranslator = $this->getVarTranslator();
        $translation   = $this->getVars();

        if (empty($spec['loop'])) {
            $this->doWork($nodes, $spec, $translation);
        } else {
            $this->loop($nodes, $spec, $translation);
        }
    }

    private function doWork(NodeList $nodes, array $spec, array $translation)
    {
        $varTranslator = $this->getVarTranslator();

        // set variables
        empty($spec['var']['set']) or
            $varTranslator->translationMerge(
                $translation,
                $spec['var']['set']
            );

        // fetch variables
        empty($spec['var']['fetch']) or
            $varTranslator->translationFetch(
                $translation,
                $spec['var']['fetch']
            );

        // default variables
        empty($spec['var']['default']) or
            $varTranslator->translationDefaults(
                $translation,
                $spec['var']['default']
            );

        if (!empty($spec['render'])) {
            foreach ($spec['render'] as $key => $value) {
                $translation[$key] = $this->view->render($value);
            }
        }

        // variable helpers
        empty($spec['var']['helper']) or
            $varTranslator->applyHelper(
                $translation,
                $spec['var']['helper'],
                $this->view->getHelperPluginManager()
            );

        $varTranslator->translate(
            $spec,
            $varTranslator->array2translation($translation)
        );

        unset($translation);

        // remove node by xpath
        !array_key_exists('remove', $spec) or
            $nodes->remove($spec['remove']);

        // replace
        !array_key_exists('replace', $spec) or
            $this->replace($nodes, $spec);

        // attribs
        !array_key_exists('attribs', $spec) or
            $this->setAttribs($nodes, $spec);

        // text value
        !array_key_exists('value', $spec) or
            $this->setValue($nodes, $spec);

        // xhtml code
        !array_key_exists('html', $spec) or
            $this->setHtml($nodes, $spec);

        // onEmpty
        !array_key_exists('onEmpty', $spec) or
            $this->onEmpty($nodes, $spec['onEmpty']);
    }

    private function loop(NodeList $nodes, array $spec, array $translation)
    {
        $varTranslator = $this->getVarTranslator();

        // todo
        if (empty($translation['items'])) {

            // onEmpty
            !array_key_exists('onEmpty', $spec['loop']) or
                $this->doWork($nodes, $spec['loop']['onEmpty'], $translation);

            return;
        }
        $items = $translation['items'];

        foreach ($nodes as $node) {

            if ($node->nextSibling) {
                $insertBefore = $node->nextSibling;
            } else {
                $insertBefore = null;
            }

            $nodeClone  = clone $node;
            $parentNode = $node->parentNode;

            $node->parentNode->removeChild($node);

            if (empty($spec['loop']['index'])) {
                $index = 0;
            } else {
                $index = $spec['loop']['index'];
            }

            foreach ($items as $key => $item) {
                $index++;

                $item['index'] = (string) $index;
                $newNode       = clone $nodeClone;
                $newNodeList   = $nodes->createNodeList(array($newNode));

                $varTranslator->translationMerge(
                    $translation,
                    $item
                );

                $this->doWork($newNodeList, $spec, $translation);

                if ($insertBefore) {
                    $parentNode->insertBefore($newNode, $insertBefore);
                } else {
                    $parentNode->appendChild($newNode);
                }
            }
        }
    }

    public function onEmpty(NodeList $nodes, array $spec)
    {
        foreach ($nodes as $node) {
            if (!empty($node->nodeValue)
                || is_numeric($node->nodeValue)
            ) {
                continue;
            }
            $this->drawNodes($nodes->createNodeList(array($node)), $spec);
        }
    }

    public function replace(NodeList $nodes, array $spec)
    {
        foreach ($nodes as $node) {
            if (is_array($spec['replace'])) {
                foreach ($spec['replace'] as $xpath => $html) {
                    $newNodes = $node->ownerDocument->xpath->query($xpath, $node);
                    $newNodes = $nodes->createNodeList($newNodes);
                    $preSet   = $this->getHtmlPreSet($html, $spec);
                    $newNodes->replace($html, $preSet);
                    $subspec  = $spec;
                    unset($subspec['replace']);
                    $this->drawNodes($newNodes, $subspec);
                }
                continue;
            } else {
                $newNodes = $nodes->createNodeList(array($node));
            }
            $newNodes = $nodes->createNodeList(array($node));
            $preSet   = $this->getHtmlPreSet($spec['replace'], $spec);
            $newNodes->replace($spec['replace'], $preSet);
            $subspec  = $spec;
            unset($subspec['replace']);
            $this->drawNodes($newNodes, $subspec);
        }
    }

    public function setValue(NodeList $nodes, array $spec)
    {
        $preSet = $this->getValuePreSet($spec);
        $nodes->setValue($spec['value'], $preSet);
    }

    public function setHtml(NodeList $nodes, array $spec)
    {
        $preSet = $this->getHtmlPreSet($spec['html'], $spec);
        $nodes->setHtml($spec['html'], $preSet);
    }

    public function setAttribs(NodeList $nodes, array $spec)
    {
        $preSet = $this->getAttribsPreSet($spec);
        $nodes->setAttribs($spec['attribs'], $preSet);
    }
}
