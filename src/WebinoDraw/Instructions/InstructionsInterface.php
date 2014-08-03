<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Instructions;

/**
 *
 */
interface InstructionsInterface
{
    /**
     * Merge draw instructions
     *
     * @param array $instructions Merge from
     * @return array Merged instructions
     */
    public function merge(array $instructions);
}
