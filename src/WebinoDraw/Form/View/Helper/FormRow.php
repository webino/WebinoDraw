<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Form\View\Helper;

use Zend\Form\View\Helper\FormRow as BaseFormRow;
use Zend\View\Helper\AbstractHelper;

class FormRow extends BaseFormRow
{
    /**
     * @param AbstractHelper $elementHelper
     * @return FormRow
     */
    public function setElementHelper(AbstractHelper $elementHelper)
    {
        $this->elementHelper = $elementHelper;
        return $this;
    }
}
