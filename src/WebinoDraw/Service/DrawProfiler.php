<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2018 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Service;

use WebinoDebug\Debugger\DebuggerInterface as Debugger;

/**
 * Class DrawProfiler
 */
class DrawProfiler
{
    /**
     * @var int
     */
    protected $n = 0;

    /**
     * @var Debugger
     */
    protected $debugger;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var float
     */
    protected $totalTime = 0;

    /**
     * @param Debugger $debugger
     */
    public function __construct(Debugger $debugger)
    {
        $this->debugger = $debugger;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = [];
        foreach ($this->data as $row) {
            $data[$row['n']] = $row;
        }
        ksort($data);
        return $data;
    }

    /**
     * @return float
     */
    public function getTotalTime()
    {
        return $this->totalTime;
    }

    /**
     * @param array $spec
     * @param $isDisabled
     */
    public function beginNodeRender(array $spec, $isDisabled)
    {
        // TODO disabled indicator

        $this->n++;

        $_spec = $spec;
        unset($_spec['_key']);

        $key = $this->createKey($spec);
        $this->data[$key] = [
            'n'    => $this->n,
            'key'  => $key,
            'spec' => $_spec,
            'time' => 0,
        ];
    }

    /**
     * @TODO method description
     */
    public function beginNodesDraw($nodes, $helper, $spec, $vars)
    {
        $this->debugger->timer(__CLASS__);
    }

    /**
     * @TODO method description
     */
    public function finishNodesDraw($nodes, $helper, $spec, $vars)
    {
        // TODO show more info (nodes, helper, vars?)

        $time = $this->debugger->timer(__CLASS__)->getDelta();
        $index = $this->createKey($spec);
        $this->data[$index]['time'] = $time;
        $this->totalTime+= $time;
    }

    /**
     * @param array $spec
     * @return string
     */
    protected function createKey(array $spec)
    {
        return empty($spec['_key']) ? '-' : $spec['_key'];
    }
}
