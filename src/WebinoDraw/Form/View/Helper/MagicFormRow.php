<?php

namespace WebinoDraw\Form\View\Helper;

use Zend\Form\View\Helper\FormRow;
use Zend\View\Helper\AbstractHelper as BaseAbstractHelper;

class MagicFormRow extends FormRow
{
    public function setElementHelper(BaseAbstractHelper $elementHelper)
    {
        $this->elementHelper = $elementHelper;
        return $this;
    }
}
