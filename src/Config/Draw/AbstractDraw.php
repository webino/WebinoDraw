<?php

namespace Webino\Config\Draw;

use Zend\Stdlib\ArrayUtils;

/**
 * Class AbstractDraw
 */
abstract class AbstractDraw
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var array
     */
    protected $spec = [];

    /**
     * @param string $key
     * @param string|array|null $locator
     */
    public function __construct(string $key, $locator = null)
    {
        $this->key = (string)$key;
        $locator and $this->setLocator($locator);
    }

    /**
     * @param string|array $locator
     * @return $this
     */
    public function setLocator($locator): AbstractDraw
    {
        $this->spec['locator'] = $locator;
        return $this;
    }

    /**
     * @param array $spec
     * @return $this
     */
    public function setSpec(array $spec): AbstractDraw
    {
        foreach ($spec as $index => $item) {

        }

        return $this;
    }

    /**
     * @param array $merge
     * @return array
     */
    protected function getDefaultOptions(array $merge = []): array
    {
        return [$this->key => ArrayUtils::merge($this->spec, $merge)];
    }

    /**
     * @param array $spec
     * @return $this
     */
    public function merge(array $spec): AbstractDraw
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
