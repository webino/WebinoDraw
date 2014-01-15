<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw;

use WebinoDraw\Stdlib\DrawInstructions;
use WebinoDraw\Stdlib\DrawInstructionsInterface;
use Zend\Stdlib\AbstractOptions;

/**
 *
 */
class WebinoDrawOptions extends AbstractOptions
{
    /**
     * @var DrawInstructionsInterface
     */
    protected $instructions;

    /**
     * @var array
     */
    protected $instructionSet = array();

    /**
     * @var string
     */
    protected $ajaxContainerXpath = '//body';

    /**
     * @var string
     */
    protected $ajaxFragmentXpath = '//*[contains(@class, "ajax-fragment") and @id]';

    /**
     * @param array $instructions
     * @return DrawInstructions
     */
    public function createInstructions(array $instructions = array())
    {
        return new DrawInstructions($instructions);
    }

    /**
     * @return DrawInstructions
     */
    public function getInstructions()
    {
        if (null === $this->instructions) {
            $this->setInstructions($this->createInstructions());
        }

        return $this->instructions;
    }

    /**
     * @param array|DrawInstructionsInterface $instructions
     * @return WebinoDrawOptions
     */
    public function setInstructions($instructions)
    {
        if (is_array($instructions)) {

            $this->instructions = $this->getInstructions();
            $this->instructions->merge($instructions);
            return $this;
        }

        if ($instructions instanceof DrawInstructionsInterface) {

            $this->instructions = $instructions;
            return $this;
        }

        throw new \UnexpectedValueException(
            'Expected array|DrawInstructionsInterface'
        );
    }

    /**
     * @return WebinoDrawOptions
     */
    public function clearInstructions()
    {
        $this->instructions = null;
        return $this;
    }

    /**
     * @return array
     */
    public function getInstructionSet()
    {
        return $this->instructionSet;
    }

    /**
     * @param array $instructionSet
     * @return WebinoDrawOptions
     */
    public function setInstructionSet(array $instructionSet)
    {
        $this->instructionSet = $instructionSet;
        return $this;
    }

    /**
     * Return instructions from set by key
     *
     * @param string $key
     * @return array
     */
    public function instructionsFromSet($key)
    {
        if (empty($this->instructionSet[$key])) {
            return array();
        }

        return $this->instructionSet[$key];
    }

    /**
     * @return string
     */
    public function getAjaxContainerXpath()
    {
        return $this->ajaxContainerXpath;
    }

    /**
     * @param string $ajaxContainerXpath
     * @return WebinoDrawOptions
     */
    public function setAjaxContainerXpath($ajaxContainerXpath)
    {
        $this->ajaxContainerXpath = $ajaxContainerXpath;
        return $this;
    }

    /**
     * @return string
     */
    public function getAjaxFragmentXpath()
    {
        return $this->ajaxFragmentXpath;
    }

    /**
     *
     * @param string $ajaxFragmentXpath
     * @return WebinoDrawOptions
     */
    public function setAjaxFragmentXpath($ajaxFragmentXpath)
    {
        $this->ajaxFragmentXpath = $ajaxFragmentXpath;
        return $this;
    }
}
