<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

use DOMDocument;
use DOMElement;
use DOMXPath;
use WebinoDraw\Exception\DOMCreationException;
use WebinoDraw\Exception\DrawException;
use WebinoDraw\Exception\InvalidArgumentException;
use WebinoDraw\Stdlib\DrawInstructionsInterface;
use WebinoDraw\WebinoDrawOptions;
use Zend\View\Renderer\PhpRenderer;

/**
 *
 */
class WebinoDraw
{
    /**
     * @var PhpRenderer
     */
    protected $renderer;

    /**
     * @var WebinoDrawOptions
     */
    protected $options;

    /**
     * @var DOMDocument
     */
    protected $domPrototype;

    /**
     * @param PhpRenderer $renderer
     * @param WebinoDrawOptions $options
     */
    public function __construct(PhpRenderer $renderer, WebinoDrawOptions $options = null)
    {
        $this->renderer = $renderer;

        if (null === $options) {
            $this->setOptions(new WebinoDrawOptions);
        } else {
            $this->setOptions($options);
        }
    }

    /**
     * @return WebinoDrawOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param WebinoDrawOptions $options
     * @return WebinoDraw
     */
    public function setOptions(WebinoDrawOptions $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return array
     */
    public function getInstructions()
    {
        return $this->options->getInstructions();
    }

    /**
     * @param array $instructions
     * @return WebinoDraw
     */
    public function setInstructions(array $instructions)
    {
        $this->options->setInstructions($instructions);
        return $this;
    }

    /**
     * @return WebinoDraw
     */
    public function clearInstructions()
    {
        $this->options->clearInstructions();
        return $this;
    }

    /**
     * Return instructions from set by key
     *
     * @param array $key
     * @return array
     */
    public function instructionsFromSet($key)
    {
        return $this->options->instructionsFromSet($key);
    }

    /**
     * Create DOM document for drawing
     *
     * @param string $xhtml XHTML valid string
     * @param bool $isXml Load as XML
     * @return DOMDocument
     * @throws DOMCreationException
     */
    public function createDom($xhtml, $isXml = false)
    {
        if (empty($xhtml) || !is_string($xhtml)) {
            throw new InvalidArgumentException(
                'Expects valid XHTML'
            );
        }

        // hack HTML5
        libxml_use_internal_errors(true);

        $dom = new DOMDocument;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $isXml ? $dom->loadXml($xhtml) : $dom->loadHtml(mb_convert_encoding($xhtml, 'HTML-ENTITIES', 'UTF-8'));
        $dom->xpath = new DOMXPath($dom);

        return $dom;
    }

    public function createXmlDom($xml)
    {
        return $this->createDom($xml, true);
    }

    /**
     * @param DOMElement $element Element with owner document
     * @param array|DrawInstructionsInterface $instructions Draw instructions
     * @param array $vars Variables to substitute instructions parameters
     * @return WebinoDraw
     * @throws DrawException
     */
    public function drawDom(DOMElement $element, $instructions, array $vars)
    {
        try {
            $resolvedInstructions = $this->resolveInstructions($instructions);
        } catch (\InvalidArgumentException $exc) {
            throw new \InvalidArgumentException($exc->getMessage(), $exc->getCode(), $exc);
        }

        try {

            $resolvedInstructions->render(
                $element,
                $this->renderer,
                $vars
            );

        } catch (\Exception $exc) {
            throw new DrawException($exc->getMessage(), $exc->getCode(), $exc);
        }

        return $this;
    }

    /**
     * Render XHTML string
     *
     * @param string $xhtml XHTML template.
     * @param array|DrawInstructionsInterface $instructions Options how to render.
     * @param array $vars Data variables.
     * @param bool $isXml Load as XML
     * @return string Rendered HTML.
     */
    public function draw($xhtml, $instructions, array $vars, $isXml = false)
    {
        try {
            $resolvedInstructions = $this->resolveInstructions($instructions);
        } catch (\InvalidArgumentException $exc) {
            throw new \InvalidArgumentException($exc->getMessage(), $exc->getCode(), $exc);
        }

        $dom = $isXml ? $this->createXmlDom($xhtml) : $this->createDom($xhtml) ;
        $this->drawDom(
            $dom->documentElement,
            $resolvedInstructions,
            $vars
        );

        return $isXml ? $dom->saveXml() : $dom->saveHtml();
    }

    /**
     *
     * @param array|DrawInstructionsInterface $instructions
     * @return DrawInstructionsInterface
     * @throws \InvalidArgumentException
     */
    protected function resolveInstructions($instructions)
    {
        if (!is_array($instructions)
            && !($instructions instanceof DrawInstructionsInterface)
        ) {
            throw new \InvalidArgumentException('Expected instructions as array|DrawInstructionsInterface');
        }

        return is_array($instructions) ? $this->options->createInstructions($instructions) : $instructions;
    }
}
