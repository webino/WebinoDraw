<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Factory;

use WebinoDraw\Instructions\Instructions;

/**
 * Class InstructionsFactory
 */
class InstructionsFactory
{
    /**
     * @param array $instructions
     * @return Instructions
     */
    public function create(array $instructions)
    {
        return new Instructions($instructions);
    }
}
