<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Exception;

use Exception;

/**
 *
 */
class InvalidLoopHelperOptionException extends InvalidArgumentException implements ExceptionInterface
{
    /**
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($option, array $spec, $code = null, Exception $previous = null)
    {
        $message = sprintf('Expected the loop callback `%s` option for spec %s', $option, print_r($spec, true));
        parent::__construct($message, $code, $previous);
    }
}
