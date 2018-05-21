<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Debugger\Bar;

use WebinoDebug\Debugger\Bar\AbstractPanel;
use WebinoDebug\Debugger\Bar\PanelInitInterface;
use WebinoDebug\Debugger\Bar\PanelInterface;
use WebinoDebug\Exception;
use WebinoDraw\Service\DrawProfiler;
use Zend\ServiceManager\ServiceManager;

/**
 * Class DrawPanel
 */
class DrawPanel extends AbstractPanel implements
    PanelInterface,
    PanelInitInterface
{
    /**
     * Profiler bar panel id
     */
    const ID = 'WebinoDraw:draw';

    /**
     * {@inheritdoc}
     */
    protected $dir = __DIR__;

    /**
     * @var DrawProfiler
     */
    private $profiler;

    /**
     * @var string
     */
    protected $title = 'WebinoDraw profiler';

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @param ServiceManager $services
     */
    public function init(ServiceManager $services)
    {
        $this->setProfiler($services->get(DrawProfiler::class));
    }

    /**
     * @return DrawProfiler
     * @throws Exception\LogicException
     */
    protected function getProfiler()
    {
        if (null === $this->profiler) {
            throw new Exception\LogicException('Expected `profiler`');
        }
        return $this->profiler;
    }

    /**
     * @param object|DrawProfiler $profiler
     * @return self
     */
    public function setProfiler(DrawProfiler $profiler)
    {
        $this->profiler = $profiler;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTab()
    {
        return $this->createIcon('draw', 'top: -3px;') . parent::getTab();
    }

    /**
     * {@inheritdoc}
     */
    public function getPanel()
    {
        return $this->renderTemplate('draw');
    }
}
