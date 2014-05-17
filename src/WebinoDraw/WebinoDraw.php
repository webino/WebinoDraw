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
use DOMXPath;
use WebinoDraw\Exception\DOMCreationException;
use WebinoDraw\Exception\DrawException;
use WebinoDraw\Exception\InvalidArgumentException;
use WebinoDraw\Instructions\InstructionsFactory;
use WebinoDraw\Instructions\InstructionsInterface;
use WebinoDraw\Instructions\InstructionsRenderer;
use WebinoDraw\WebinoDrawOptions;

/**
 *
 */
class WebinoDraw
{
    /**
     * @var WebinoDrawOptions
     */
    protected $options;

    protected $instructionsFactory;

    protected $instructionsRenderer;

    /**
     * @param WebinoDrawOptions $options
     */
    public function __construct(WebinoDrawOptions $options, InstructionsFactory $instructionsFactory,
                                InstructionsRenderer $instructionsRenderer)
    {
        $this->options              = $options;
        $this->instructionsFactory  = $instructionsFactory;
        $this->instructionsRenderer = $instructionsRenderer;
    }

    /**
     * @return WebinoDrawOptions
     */
    // todo deprecated, remove
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
     * @return WebinoDraw
     */
    public function setInstructions(array $instructions)
    {
        $this->options->getInstructions()->merge($instructions);
        return $this;
    }

    /**
     * @return WebinoDraw
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
     * @throws DOMCreationException
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
        $dom->registerNodeClass('DOMAttr', 'WebinoDraw\Dom\Attr');

        $isXml ? $dom->loadXml($xhtml)
               : $dom->loadHtml(mb_convert_encoding($xhtml, 'HTML-ENTITIES', 'UTF-8'));

        $dom->xpath = new DOMXPath($dom);
        return $dom;
    }

    public function createXmlDom($xml)
    {
        return $this->createDom($xml, true);
    }

    /**
     * @param Dom\Element $element Element with owner document
     * @param array|InstructionsInterface $instructions Draw instructions
     * @param array $vars Variables to substitute instructions parameters
     * @return WebinoDraw
     * @throws DrawException
     */
    public function drawDom(Dom\Element $element, $instructions, array $vars)
    {
        try {
            $this->instructionsRenderer->render($instructions, $element, $vars);
        } catch (\Exception $exc) {
            throw new DrawException($exc->getMessage(), $exc->getCode(), $exc);
        }
        return $this;
    }

    /**
     * Render XHTML string
     *
     * @param string $xhtml XHTML template.
     * @param array|InstructionsInterface $instructions Options how to render.
     * @param array $vars Data variables.
     * @param bool $isXml Load as XML
     * @return string Rendered HTML.
     */
    public function draw($xhtml, $instructions, array $vars, $isXml = false)
    {
        try {
            $drawInstructions = $this->createInstructions($instructions);
        } catch (\InvalidArgumentException $exc) {
            throw new \InvalidArgumentException($exc->getMessage(), $exc->getCode(), $exc);
        }

        $dom = $isXml ? $this->createXmlDom($xhtml) : $this->createDom($xhtml);
        $this->drawDom(
            $dom->documentElement,
            $drawInstructions,
            $vars
        );

        return $isXml ? $dom->saveXml() : $dom->saveHtml();
    }

    /**
     *
     * @param array|InstructionsInterface $instructions
     * @return InstructionsInterface
     * @throws \InvalidArgumentException
     */
    protected function createInstructions($instructions)
    {
        if (!($instructions instanceof InstructionsInterface)
            && !is_array($instructions)
        ) {
            throw new \InvalidArgumentException(
                'Expected instructions as array|InstructionsInterface'
            );
        }

        return is_array($instructions) ? $this->instructionsFactory->create($instructions)
                                       : $instructions;
    }
}
