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
     * @param array $render
     * @return $this
     */
    public function setRender(array $render): Element
    {
        $this->spec['render'] = $render;
        return $this;
    }

    /**
     * @param Element\Loop $loop
     * @return $this
     */
    public function setLoop(Element\Loop $loop): Element
    {
        $this->spec['loop'] = $loop->toArray();
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
