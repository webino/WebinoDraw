<?php

namespace Webino\Config\Draw;

use Zend\Stdlib\ArrayUtils;

/**
 * Class SubSpec
 */
class SubSpec extends Spec
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        $options = parent::toArray();

        foreach ($options as $index => $option) {
            if (is_object($option)) {
                switch (true) {

                    case $option instanceof AbstractSubSpecItem:
                        $option->toSpec($options);
                        unset($options[$index]);
                        break;
                }
            }
        }

        return $options;
    }
}
