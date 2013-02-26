<?php

namespace WebinoDraw;

use Zend\EventManager\Event;

class DrawEvent extends Event
{
    public function getNode()
    {
        return $this->getParam('node');
    }

    public function setNode(\DOMNode $node)
    {
        $this->setParam('node', $node);
        return $this;
    }

    public function getSpec()
    {
        return $this->getParam('spec');
    }

    public function setSpec(array $spec)
    {
        $this->setParam(
            'spec',
            array_replace_recursive(
                $this->getParam('spec', array()),
                $spec
            )
        );
        return $this;
    }

    public function clearSpec()
    {
        $this->setParam('spec', array());
        return $this;
    }
}
