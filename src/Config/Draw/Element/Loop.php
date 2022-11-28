<?php

namespace Webino\Config\Draw\Element;

use Webino\Config\Draw\SubSpec;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Loop
 */
class Loop
{
    /**
     * @var array
     */
    protected $spec = [];

    /**
     * @param string|null $base
     * @param array $spec
     */
    public function __construct(string $base = null, array $spec = [])
    {
        is_string($base) and $spec['base'] = $base;
        is_array($base) and $this->spec = $base;
        is_array($spec) and $this->spec = $spec;
    }

    /**
     * @param string|array|object $locator
     * @return $this
     */
    public function setOnEmptyRemove($locator): Loop
    {
        isset($this->spec['onEmpty']) or $this->spec['onEmpty'] = [];
        $this->spec['onEmpty']['remove'] = is_array($locator) ? $locator : (string)$locator;
        return $this;
    }

    /**
     * @param array $spec
     * @return $this
     */
    public function setSpec(array $spec): Loop
    {
        $this->spec = ArrayUtils::merge($this->spec, (new SubSpec($spec))->toArray());
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->spec;
    }
}
