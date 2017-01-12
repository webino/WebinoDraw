<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Form\View\Helper;

use Zend\Form\View\Helper\FormRow as BaseFormRow;

/**
 * Class FormRow
 */
class FormRow extends BaseFormRow
{
    /**
     * View helper service name
     */
    const SERVICE = 'webinodrawformrow';

    /**
     * @return FormElement
     */
    public function getElementHelper()
    {
        if (null === $this->elementHelper) {
            $this->elementHelper = $this->getView()->plugin(FormElement::SERVICE);
        }
        return $this->elementHelper;
    }
}
