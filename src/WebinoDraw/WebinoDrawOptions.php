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

use WebinoDraw\Instructions\Instructions;
use WebinoDraw\Instructions\InstructionsInterface;
use Zend\Stdlib\AbstractOptions;

/**
 *
 */
class WebinoDrawOptions extends AbstractOptions
{
    /**
     * @var InstructionsInterface
     */
    protected $instructions;

    /**
     * @var array
     */
    protected $instructionSet = [];

    /**
     * @var string
     */
    protected $ajaxContainerXpath = '//body';

    /**
     * @var string
     */
    protected $ajaxFragmentXpath = '//*[contains(@class, "ajax-fragment") and @id]';

    /**
     * @return Instructions
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * @param InstructionsInterface $instructions
     * @return WebinoDrawOptions
     */
    public function setInstructions(InstructionsInterface $instructions)
    {
        $this->instructions = $instructions;
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
            return [];
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
