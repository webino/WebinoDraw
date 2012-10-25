<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_View
 */

namespace WebinoDraw\View\Strategy;

use WebinoDraw\Dom\Draw;
use WebinoDraw\Stdlib\DrawInstructions;
use Zend\EventManager\EventManagerInterface;
use Zend\View\Strategy\PhpRendererStrategy;
use Zend\View\ViewEvent;

/**
 * @category    Webino
 * @package     WebinoDraw_View
 * @subpackage  Strategy
 */
class DrawStrategy extends PhpRendererStrategy
{
    /**
     * @var WebinoDraw\Dom\Draw
     */
    private $draw;

    /**
     * @var array
     */
    private $instructions = array();

    /**
     * @var array
     */
    private $instructionset = array();

    /**
     * @param \WebinoDraw\Dom\Draw $draw
     */
    public function __construct(Draw $draw)
    {
        $this->draw = $draw;
    }

    /**
     * Return draw instructions.
     *
     * @return array
     */
    public function getInstructions()
    {
        ksort($this->instructions);
        return $this->instructions;
    }

    /**
     * Add draw instructions.
     *
     * @param  array $instructions
     * @return DrawStrategy
     */
    public function setInstructions(array $instructions)
    {
        $this->instructions = DrawInstructions::merge(
            $this->getInstructions(),
            $instructions
        );
        return $this;
    }

    /**
     * Clear all instructions.
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
     * @param  array $key
     * @return array
     */
    public function getInstructionsFromSet($key)
    {
        if (empty($this->instructionset[$key])) {
            return array();
        }
        return $this->instructionset[$key];
    }

    /**
     * Set array of instruction set list.
     *
     * @param  array $instructionset
     * @return \Webino\View\Strategy\DrawStrategy
     */
    public function setInstructionSet(array $instructionset)
    {
        $this->instructionset = $instructionset;
        return $this;
    }

    /**
     * Attach the aggregate to the specified event manager.
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
     * Render XHTML tempalte string.
     *
     * @param  string $xhtml XHTML template.
     * @param  array $instructions Options how to render.
     * @param  array $vars Data variables.
     * @return string Rendered HTML.
     */
    public function draw($xhtml, array $instructions, array $vars)
    {
        return $this->draw->drawXhtml($xhtml, $instructions, $vars);
    }

    /**
     * Populate the response object from the View.
     *
     * Populates the content of the response object from the view rendering
     * results.
     *
     * @param  ViewEvent $event
     * @return void
     */
    public function injectResponse(ViewEvent $event)
    {
        if (!($event->getRenderer() instanceof \Zend\View\Renderer\PhpRenderer)) {
            return;
        }

        parent::injectResponse($event);

        $response     = $event->getResponse();
        $responseBody = $response->getBody();

        if (empty($responseBody)) {
            return;
        }

        $model = $event->getModel();
        $vars  = $model->getVariables()->getArrayCopy();

        // get variables from model children
        foreach ($model->getChildren() as $child) {
            $childVars = $child->getVariables();
            if ($childVars instanceof \ArrayObject) {
                $childVars = $childVars->getArrayCopy();
            }
            $vars = array_replace($vars, $childVars);
        }

        // draw response body to content
        $response->setContent(
            $this->draw(
                $responseBody,
                $this->getInstructions(),
                $vars
            )
        );
    }
}
