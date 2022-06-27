<?php

namespace WebinoDraw\Controller\Plugin;

use WebinoDraw\Event\AjaxEvent;
use WebinoDraw\View\Strategy\AbstractDrawAjaxStrategy;
use WebinoDraw\View\Strategy\AbstractDrawStrategy;
use WebinoDraw\View\Strategy\DrawStrategy;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mvc\Controller\PluginManager;
use Zend\Stdlib\ArrayUtils;

/**
 * Class DrawAjaxJson
 */
class DrawAjaxJson extends AbstractPlugin
{
    /**
     * @var AbstractDrawStrategy
     */
    private $draw;

    /**
     * @param PluginManager $plugins
     * @return DrawAjaxJson
     */
    public static function create(PluginManager $plugins): DrawAjaxJson
    {
        $services = $plugins->getServiceLocator();
        
        return new static($services->get(DrawStrategy::SERVICE));
    }

    /**
     * @param AbstractDrawStrategy|object $draw
     */
    public function __construct(AbstractDrawStrategy $draw)
    {
        $this->draw = $draw;
    }

    /**
     * @param array|object $json
     * @return bool
     */
    public function __invoke($json)
    {
        if ($this->draw instanceof AbstractDrawAjaxStrategy) {
            $this->draw->getEventManager()->attach(
                AjaxEvent::EVENT_AJAX,
                function (AjaxEvent $event) use ($json) {
                    $event->setJson(is_array($json) ? $json : ArrayUtils::iteratorToArray($json));
                }
            );
        }
        
        return false;
    }
}
