<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Service;

use DOMDocument;
use DOMXPath;
use WebinoDraw\Dom\Element;
use WebinoDraw\Exception\DrawException;
use WebinoDraw\Exception\InvalidArgumentException;
use WebinoDraw\Instructions\InstructionsInterface;
use WebinoDraw\Instructions\InstructionsRenderer;
use WebinoDraw\Options\ModuleOptions;

/**
 *
 */
class DrawService
{
    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @var InstructionsRenderer
     */
    protected $instructionsRenderer;

    /**
     * @param ModuleOptions $options
     * @param InstructionsRenderer $instructionsRenderer
     */
    public function __construct(ModuleOptions $options, InstructionsRenderer $instructionsRenderer)
    {
        $this->options              = $options;
        $this->instructionsRenderer = $instructionsRenderer;
    }

    /**
     * @return ModuleOptions
     */
    public function getOptions()
    {
        return $this->options;
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
     * @return self
     */
    public function setInstructions(array $instructions)
    {
        $this->options->getInstructions()->merge($instructions);
        return $this;
    }

    /**
     * @return self
     */
    public function clearInstructions()
    {
        $this->options->getInstructions()->exchangeArray([]);
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
     * @throws InvalidArgumentException
     */
    public function createDom($xhtml, $isXml = false)
    {
        if (empty($xhtml) || !is_string($xhtml)) {
            throw new InvalidArgumentException('Expects valid XHTML');
        }

        // hack HTML5
        libxml_use_internal_errors(true);

        $dom = new DOMDocument;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->registerNodeClass('DOMText', 'WebinoDraw\Dom\Text');
        $dom->registerNodeClass('DOMAttr', 'WebinoDraw\Dom\Attr');

        $isXml ? $dom->loadXml($xhtml)
               : $dom->loadHtml(mb_convert_encoding($xhtml, 'HTML-ENTITIES', 'UTF-8'));

        $dom->xpath = new DOMXPath($dom);
        return $dom;
    }

    /**
     * @param string $xml
     * @return DOMDocument
     */
    public function createXmlDom($xml)
    {
        return $this->createDom($xml, true);
    }

    /**
     * @param Element $element Element with owner document
     * @param array|InstructionsInterface $instructions Options how to render
     * @param array $vars Variables to substitute instructions parameters
     * @return self
     * @throws DrawException
     */
    public function drawDom(Element $element, $instructions, array $vars)
    {
        try {
            $this->instructionsRenderer->render($element, $instructions, $vars);
        } catch (\Exception $exc) {
            throw new DrawException($exc->getMessage(), $exc->getCode(), $exc);
        }
        return $this;
    }

    /**
     * Render XHTML string
     *
     * @param string $xhtml XHTML template
     * @param array|InstructionsInterface $instructions Options how to render
     * @param array $vars Data variables
     * @param bool $isXml Load as XML
     * @return string Rendered HTML
     */
    public function draw($xhtml, $instructions, array $vars, $isXml = false)
    {
        $dom = $isXml ? $this->createXmlDom($xhtml) : $this->createDom($xhtml);
        $this->drawDom($dom->documentElement, $instructions, $vars);
        return $isXml ? $dom->saveXml() : $dom->saveHtml();
    }

    /**
     * Render XML string
     *
     * @param string $xhtml XHTML template
     * @param array|InstructionsInterface $instructions Options how to render
     * @param array $vars Data variables
     * @return string Rendered XML
     */
    public function drawXml($xhtml, $instructions, array $vars)
    {
        return $this->draw($xhtml, $instructions, $vars, true);
    }
}
