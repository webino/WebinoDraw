<?php

namespace Webino\Config\Draw\Element;

use Webino\Config\Draw\AbstractSubSpecItem;
use Webino\Config\Draw\SubSpec;
use Zend\Stdlib\ArrayUtils;

/**
 * Class OnVar
 */
class OnVar extends AbstractSubSpecItem
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $spec = [];

    /**
     * @param string $name
     * @param string $var
     */
    public function __construct($name, $var)
    {
        $this->name = (string)$name;
        $this->spec['var'] = (string)$var;
    }

    /**
     * @param mixed $expected
     * @return $this
     */
    public function setEqualTo($expected): OnVar
    {
        $this->spec['equalTo'] = $expected;
        return $this;
    }

    /**
     * @param mixed $expected
     * @return $this
     */
    public function setNotEqualTo($expected): OnVar
    {
        $this->spec['notEqualTo'] = $expected;
        return $this;
    }

    /**
     * @param array $spec
     * @return $this
     */
    public function setSpec(array $spec): OnVar
    {
        $this->spec = ArrayUtils::merge($this->spec, (new SubSpec($spec))->toArray());
        return $this;
    }

    /**
     * @param array $spec
     * @return array
     */
    public function toSpec(array &$spec): array
    {
        isset($spec['onVar']) or $spec['onVar'] = [];
        $spec['onVar'] = ArrayUtils::merge($spec['onVar'], $this->toArray());
        return $spec;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [$this->name => $this->spec];
    }
}
