<?php

namespace Webino\Config\Draw;

use Zend\Stdlib\ArrayUtils;

/**
 * Class Spec
 */
class Spec
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $options = $this->options;

        foreach ($options as $index => $option) {
            if (is_object($option)) {
                switch (true) {

                    case $option instanceof AbstractDraw:
                        isset($options['instructions']) or $options['instructions'] = [];
                        $options['instructions'] = ArrayUtils::merge($options['instructions'], $option->toArray());
                        unset($options[$index]);
                        break;

                    case $option instanceof AbstractVariable:
                        isset($options['var']) or $options['var'] = [];
                        $options['var'] = ArrayUtils::merge($options['var'], $option->toArray());
                        unset($options[$index]);
                        break;
                }
            }
        }

        return $options;
    }
}
