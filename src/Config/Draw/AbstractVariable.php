<?php

namespace Webino\Config\Draw;

use Zend\Stdlib\ArrayUtils;

/**
 * Class AbstractVariable
 */
abstract class AbstractVariable
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
     */
    public function __construct(string $name)
    {
        $this->name = (string)$name;
    }

    /**
     * @param array $merge
     * @return array
     */
    protected function getDefaultOptions(array $merge = []): array
    {
        return [$this->name => ArrayUtils::merge($this->spec, $merge)];
    }

    /**
     * @param array $spec
     * @return $this
     */
    public function merge(array $spec): AbstractVariable
    {
        $this->spec = ArrayUtils::merge($this->spec, $spec);
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->getDefaultOptions();
    }
}
