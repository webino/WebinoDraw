<?php

namespace Webino\Config\Draw;

/**
 * Class Element
 */
abstract class Element extends AbstractDraw
{
    /**
     * @param int $stackIndex
     * @return $this
     */
    public function setStackIndex(int $stackIndex): Element
    {
        $this->spec['stackIndex'] = $stackIndex;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue(string $value): Element
    {
        $this->spec['value'] = $value;
        return $this;
    }

    /**
     * @param string $html
     * @return $this
     */
    public function setHtml($html): Element
    {
        $this->spec['html'] = (string)$html;
        return $this;
    }

    /**
     * @param array $render
     * @return $this
     */
    public function setRender(array $render): Element
    {
        $this->spec['render'] = $render;
        return $this;
    }
}
