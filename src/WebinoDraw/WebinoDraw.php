<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
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
     * @return DOMDocument
     * @throws DOMCreationException
     */
    public function createDom($xhtml)
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
        $dom->loadHtml($xhtml);

        $dom->xpath = new DOMXPath($dom);

        return $dom;
    }

    /**
     * @param DOMElement $element Element with owner document
     * @param DrawInstructionsInterface $instructions Draw instructions
     * @param array $vars Variables to substitute instructions parameters
     * @return WebinoDraw
     * @throws DrawException
     */
    public function drawDom(DOMElement $element, DrawInstructionsInterface $instructions, array $vars)
    {
        try {

            $instructions->render(
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
     * @param DrawInstructionsInterface $instructions Options how to render.
     * @param array $vars Data variables.
     * @return string Rendered HTML.
     */
    public function draw($xhtml, DrawInstructionsInterface $instructions, array $vars)
    {
        $dom = $this->createDom($xhtml);

        $this->drawDom($dom->documentElement, $instructions, $vars);

        return $dom->saveHTML();
    }
}
