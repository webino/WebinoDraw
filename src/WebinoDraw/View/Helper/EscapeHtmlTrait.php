<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\View\Helper;

use Zend\View\Helper\EscapeHtml;

/**
 * Trait EscapeHtmlTrait
 */
trait EscapeHtmlTrait
{
    /**
     * @var EscapeHtml
     */
    protected $escapeHtml;

    /**
     * @return EscapeHtml
     */
    public function getEscapeHtml()
    {
        if (null === $this->escapeHtml) {
            $this->setEscapeHtml(new EscapeHtml);
        }
        return $this->escapeHtml;
    }

    /**
     * @param EscapeHtml $escapeHtml
     * @return $this
     */
    public function setEscapeHtml(EscapeHtml $escapeHtml)
    {
        $this->escapeHtml = $escapeHtml;
        return $this;
    }
}
