<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Options;

use WebinoDraw\Instructions\Instructions;
use WebinoDraw\Instructions\InstructionsInterface;
use Zend\Stdlib\AbstractOptions;

/**
 * Class ModuleOptions
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * Application service name
     */
    const SERVICE = 'WebinoDrawOptions';

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
    protected $ajaxFragmentXpath = '//*[contains(@class, "ajax-fragment") and @id]
                                    [not(.//*[contains(@class, "ajax-fragment")])]';

    /**
     * @return Instructions
     */
    public function getInstructions()
    {
        if (null === $this->instructions) {
            $this->setInstructions(new Instructions);
        }
        return $this->instructions;
    }

    /**
     * @param InstructionsInterface $instructions
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
     */
    public function setAjaxFragmentXpath($ajaxFragmentXpath)
    {
        $this->ajaxFragmentXpath = $ajaxFragmentXpath;
        return $this;
    }
}
