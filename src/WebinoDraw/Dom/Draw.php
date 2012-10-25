<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_Dom
 */

namespace WebinoDraw\Dom;

use WebinoDraw\Exception;
use WebinoDraw\Dom\NodeList;
use Zend\Dom\Css2Xpath;
use Zend\View\Renderer\PhpRenderer;

/**
 * Use instructions and data to render XHTML.
 *
 * @category    Webino
 * @package     WebinoDraw_Dom
 */
class Draw
{
    /**
     * @var Zend\View\Renderer\PhpRenderer
     */
    private $renderer;

    /**
     * @param \Zend\View\Renderer\PhpRenderer $renderer
     */
    public function __construct(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Draw XHTML string.
     *
     * @param  string $xhtml Valid XHTML string.
     * @return string Drawed HTML string.
     */
    public function drawXhtml($xhtml, array $instructions, array $vars)
    {
        if (empty($xhtml)) {
            throw new Exception\InvalidArgumentException(
                'Expects valid XHTML'
            );
        }

        // hack HTML5
        libxml_use_internal_errors(true);

        $doc                      = new \DOMDocument;
        $doc->preserveWhiteSpace  = false;
        $doc->formatOutput        = false;
        $doc->substituteEntities  = false;
        $doc->strictErrorChecking = false;
        $doc->loadHtml($xhtml);
        $doc->xpath               = new \DOMXpath($doc);

        $this->drawDom($doc, $instructions, $vars);
        return $doc->saveHTML();
    }

    /**
     * Draw DOM document.
     *
     * @param  \DOMDocument $doc DOM to modify.
     * @param  array $instructions List of draw instructions.
     * @param  array $vars Array of data.
     * @return \WebinoDraw\Dom\Draw
     * @throws Exception\InvalidArgumentException
     * @throws Exception\InvalidInstructionException
     */
    public function drawDom(\DOMDocument $doc, array $instructions, array $vars)
    {
        if (empty($doc->xpath)) {
            throw new Exception\InvalidArgumentException(
                'Expects document with XPATH'
            );
        }

        foreach ($instructions as $node) {
            $spec  = current($node);
            $xpath = array();

            // skip unmapped instructions
            if (empty($spec['xpath']) && empty($spec['query'])) continue;

            if (!empty($spec['xpath'])) {
                if (!is_array($spec['xpath'])) $xpath[] = $spec['xpath'];
                else $xpath = array_merge($xpath, $spec['xpath']);
            };
            // transform css query to xpath
            if (!empty($spec['query'])) {
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
            $plugin->drawNodes(new NodeList($nodes), $spec);
        }
        return $this;
    }
}
