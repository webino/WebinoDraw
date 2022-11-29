<?php

namespace Webino\Config\Draw;

/**
 * Class Element
 */
class Element extends AbstractDraw
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
     * @param string $html
     * @return $this
     */
    public function setReplace($html): Element
    {
        $this->spec['replace'] = (string)$html;
        return $this;
    }

    /**
     * @param string|array $locator
     * @return $this
     */
    public function setRemove($locator): Element
    {
        $this->spec['remove'] = $locator;
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

    /**
     * @param array $trigger
     * @return $this
     */
    public function setTrigger(array $trigger): Element
    {
        $this->spec['trigger'] = $trigger;
        return $this;
    }

    /**
     * @param array $attribs
     * @return $this
     */
    public function setAttribs(array $attribs): Element
    {
        isset($this->spec['attribs']) or $this->spec['attribs'] = [];
        $this->spec['attribs'] = array_replace($this->spec['attribs'], $attribs);
        return $this;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function setClass($class): Element
    {
        $this->spec['attribs']['class'] = (string)$class;
        return $this;
    }

    /**
     * @param string|array $locator
     * @return $this
     */
    public function setOnEmptyRemove($locator): Element
    {
        $this->spec['onEmpty']['remove'] = is_array($locator) ? $locator : (string) $locator;
        return $this;
    }
}
