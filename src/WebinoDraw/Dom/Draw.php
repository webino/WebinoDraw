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
use WebinoDraw\Stdlib\DrawInstructions;
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
        DrawInstructions::render(
            $doc->documentElement,
            $this->renderer,
            $instructions,
            $vars
        );
        return $this;
    }
}
