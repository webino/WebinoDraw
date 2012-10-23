<?php
/**
 * Webino (http://zf.webino.org/)
 *
 * @copyright   Copyright (c) 2012 Peter Bačinský (http://www.bacinsky.sk/)
 * @license     New BSD License
 * @package     WebinoDraw
 */

namespace WebinoDraw\View\Strategy;

use WebinoDraw\Exception;
use WebinoDraw\Dom\NodeList;
use Zend\Dom\Css2Xpath;
use Zend\EventManager\EventManagerInterface;
use Zend\View\Strategy\PhpRendererStrategy;
use Zend\View\ViewEvent;

/**
 * @category    Webino
 * @package     WebinoDraw
 * @subpackage  ViewStrategy
 * @author      Peter Bačinský <peter@bacinsky.sk>
 */
class DrawStrategy extends PhpRendererStrategy
{
    /**
     * Stack space before instruction without index
     */
    const STACK_SPACER = 10;

    /**
     *
     * @var array
     */
    private $instructions = array();
    
    /**
     * 
     *
     * @var array
     */
    private $instructionset = array();
    
    /**
     *
     * @return array
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     *
     * @param array $instructions
     * @return DrawStrategy
     *
     * @throws Exception\InvalidInstructionException
     */
    public function setInstructions(array $instructions)
    {
        $_instructions = $this->getInstructions();
        $instructionsN = count($_instructions) * self::STACK_SPACER;

        foreach ($_instructions as &$spec) {
            foreach ($instructions as $iKey => $iSpec) {
                if (key($spec) != $iKey) continue;
                // merge existing spec
                unset($instructions[$iKey]);
                $spec = array_replace_recursive($spec, array($iKey => $iSpec));
            }
        }
        unset($spec);
        foreach ($instructions as $index => $spec) {

            if (!is_array($spec)) throw new Exception\InvalidInstructionException(
                sprintf('Instruction node spec expect array', print_r($spec, 1))
            );

            if (!isset($spec['stackIndex']) ) {
                // add without stack index
                $stackIndex = $instructionsN + self::STACK_SPACER;
                if (!isset($_instructions[$stackIndex])) {
                    $instructionsN = $stackIndex;
                    $_instructions[$stackIndex][$index] = $spec;
                    continue;
                }
                unset($stackIndex);
                
            } elseif (!isset($_instructions[$spec['stackIndex']])) {
                // add with stackindex
                $_instructions[$spec['stackIndex']][$index] = $spec;
                continue;
            }
            throw new Exception\InvalidInstructionException(
                sprintf('Stack index already exists `%s`', print_r($spec, 1))
            );
        }
        $this->instructions = $_instructions;
        return $this;
    }

    /**
     *
     * @return DrawStrategy
     */
    public function clearInstructions()
    {
        $this->instructions = array();
        return $this;
    }
    
    /**
     * Return instructions from set by key.
     * 
     * @param array $key
     * @return array
     */
    public function getInstructionsFromSet($key)
    {
        if (empty($this->instructionset[$key])) return array();
        return $this->instructionset[$key];
    }
    
    /**
     * Set array of instruction set list.
     * 
     * @param array $instructionset
     * @return \Webino\View\Strategy\DrawStrategy
     */
    public function setInstructionSet(array $instructionset)
    {
        $this->instructionset =  $instructionset;
        return $this;
    }

    /**
     * Attach the aggregate to the specified event manager
     *
     * @param  EventManagerInterface $events
     * @param  int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        parent::attach($events, $priority - 100); // as last
    }

    /**
     *
     * @param string $xhtml
     * @return string
     */
    public function draw($xhtml, array $vars)
    {
        if (empty($xhtml)) throw new Exception\InvalidArgumentException(
            'Expects valid xhtml'
        );

        libxml_use_internal_errors(true); // hack HTML5
        $doc                      = new \DOMDocument;
        $doc->preserveWhiteSpace  = false;
        $doc->formatOutput        = false;
        $doc->substituteEntities  = false;
        $doc->strictErrorChecking = false;
        $doc->loadHtml($xhtml);
        $doc->xpath   = new \DOMXpath($doc);
        $instructions = $this->getInstructions();
        ksort($instructions);
        $this->drawDomDocument($doc, $instructions, $vars);
        return $doc->saveHTML();
    }

    /**
     *
     * @param \DOMDocument $doc
     * @param array $instructions
     * @return DrawStrategy
     */
    public function drawDomDocument(\DOMDocument $doc, array $instructions, array $vars)
    {
        if (empty($doc->xpath)) throw new Exception\InvalidArgumentException(
            'Expects document with xpath'
        );

        foreach ($instructions as $node) {
            $key   = key($node);
            $spec  = current($node);
            $xpath = array();

            // skip unmapped instructions
            if (empty($spec['xpath']) && empty($spec['query'])) continue;

            if (!empty($spec['xpath'])) {
                if (!is_array($spec['xpath'])) $xpath[] = $spec['xpath'];
                else $xpath = array_merge($xpath, $spec['xpath']);
            };
            if (!empty($spec['query'])) { // transform css query to xpath
                if (!is_array($spec['query'])) $xpath[] = Css2Xpath::transform($spec['query']);
                else $xpath = array_merge($xpath, array_map(function($value){
                    return Css2Xpath::transform($value);
                }, $spec['query']));
            }

            if (empty($xpath)) throw new Exception\InvalidInstructionException(
                sprintf("Option `xpath` expected '%s'", print_r($spec, 1))
            );

            $xpath = join('|', $xpath);
            $nodes = $doc->xpath->query($xpath);

            // skip missing node
            if (!$nodes || !$nodes->length) continue;

            if (empty($spec['helper'])) throw new Exception\InvalidInstructionException(
                sprintf("Option `helper` expected '%s'", print_r($spec, 1))
            );

            $plugin = $this->renderer->plugin($spec['helper']);
            $plugin->setVars($vars);
            $plugin(new NodeList($nodes), $spec); // invoke helper
        }
        return $this;
    }

    /**
     * Populate the response object from the View
     *
     * Populates the content of the response object from the view rendering
     * results.
     *
     * @param ViewEvent $e
     * @return void
     */
    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) return;

        parent::injectResponse($e);

        $response = $e->getResponse();
        $result   = $response->getBody();

        if (empty($result)) return;

        $model = $e->getModel();
        $vars  = $model->getVariables()->getArrayCopy();

        // get variables from model children
        foreach ($model->getChildren() as $child) {
            $childVars = $child->getVariables();
            if ($childVars instanceof \ArrayObject)
                $childVars = $childVars->getArrayCopy();
            $vars = array_replace($vars, $childVars);
        }
        // draw response body to content
        $response->setContent($this->draw($result, $vars));
    }
}
