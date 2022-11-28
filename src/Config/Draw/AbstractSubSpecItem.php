<?php

namespace Webino\Config\Draw;

/**
 * Class AbstractSubSpecItem
 */
abstract class AbstractSubSpecItem
{
    /**
     * @param array $spec
     * @return array
     */
    abstract public function toSpec(array &$spec): array;
}
