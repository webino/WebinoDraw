<?php

namespace Webino\Config\Draw;

/**
 * Class Variable
 */
class Variable extends AbstractVariable
{
    /**
     * @param string $path
     * @return $this
     */
    public function setFetch(string $path): Variable
    {
        $this->spec['fetch'][$this->name] = $path;
        return $this;
    }
}
