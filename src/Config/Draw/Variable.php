<?php

namespace Webino\Config\Draw;

/**
 * Class Variable
 */
class Variable extends AbstractVariable
{
    /**
     * @param mixed $default
     * @return $this
     */
    public function setDefault($default = null): Variable
    {
        $this->spec['set'][$this->name] = $default;
        return $this;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setFetch(string $path): Variable
    {
        $this->spec['fetch'][$this->name] = $path;
        return $this;
    }

    /**
     * @param array|object $spec
     * @return $this
     */
    public function setHelper($spec): Variable
    {
        // TODO helper object support
        $this->spec['helper'][$this->name] = is_array($spec) ? $spec : [];
        return $this;
    }
}
