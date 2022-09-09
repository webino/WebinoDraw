<?php

namespace Webino\Config\Draw;

/**
 * Class Variable
 */
abstract class Variable extends AbstractVariable
{
    /**
     * @param int $stackIndex
     * @return $this
     */
    public function setFetch(int $stackIndex): Variable
    {
        return $this;
    }
}
