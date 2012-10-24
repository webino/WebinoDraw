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

use WebinoDraw\Exception;
use WebinoDraw\Dom\Draw;
use Zend\EventManager\EventManagerInterface;
use Zend\View\Strategy\PhpRendererStrategy;
use Zend\View\ViewEvent;

/**
 * @package     WebinoDraw_View
 * @subpackage  Strategy
 */
class DrawStrategy extends PhpRendererStrategy
{
    /**
     * Stack space before instruction without index
     */
    const STACK_SPACER = 10;

    private $draw;
    
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
    
    public function __construct(Draw $draw)
    {
        $this->draw = $draw;
    }
    
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
    public function draw($xhtml, array $instructions, array $vars)
    {
        return $this->draw->draw($xhtml, $instructions, $vars);
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
        if (!($e->getRenderer() instanceof \Zend\View\Renderer\PhpRenderer)) {
            return;
        }

        parent::injectResponse($e);

        $response     = $e->getResponse();
        $responseBody = $response->getBody();

        if (empty($responseBody)) {
            return;
        }

        $model = $e->getModel();
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
        $instructions = $this->getInstructions();
        ksort($instructions);
        $content = $this->draw($responseBody, $instructions, $vars);
        $response->setContent($content);
    }
}
