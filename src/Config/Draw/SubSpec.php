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

                    case $option instanceof AbstractVariable:
                        isset($options['var']) or $options['var'] = [];
                        $options['var'] = ArrayUtils::merge($options['var'], $option->toArray());
                        unset($options[$index]);
                        break;

                    case $option instanceof Element\OnVar:
                        isset($options['onVar']) or $options['onVar'] = [];
                        $options['onVar'] = ArrayUtils::merge($options['onVar'], $option->toArray());
                        unset($options[$index]);
                        break;
                }
            }
        }

        return $options;
    }
}
