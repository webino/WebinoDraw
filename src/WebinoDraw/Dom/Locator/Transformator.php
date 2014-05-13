<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Dom\Locator;

use ArrayObject;
use WebinoDraw\Dom\Locator\StrategyFactory;
use WebinoDraw\Dom\Locator\TransformatorInterface;

class Transformator extends ArrayObject implements
    TransformatorInterface
{
    /**
     * @var StrategyFactory
     */
    protected $strategyFactory;

    /**
     * @return StrategyFactory
     */
    public function getStrategyFactory()
    {
        if (null === $this->strategyFactory) {
            $this->setStrategyFactory(new StrategyFactory);
        }

        return $this->strategyFactory;
    }

    /**
     * @param StrategyFactory $factory
     * @return Transformator
     */
    public function setStrategyFactory(StrategyFactory $factory)
    {
        $this->strategyFactory = $factory;
        return $this;
    }

    /**
     * @param string $index Strategy type
     * @return mixed
     */
    public function offsetGet($index)
    {
        if (!$this->offsetExists($index)) {
            $this->offsetSet(
                $index,
                $this->getStrategyFactory()->createStrategy($index)
            );
        }

        return parent::offsetGet($index);
    }

    /**
     * Add strategy
     *
     * @param string $index Strategy type
     * @param TransformatorInterface $strategy
     * @return void
     * @throws \UnexpectedValueException
     */
    public function offsetSet($index, $strategy)
    {
        if (!($strategy instanceof TransformatorInterface)) {
            throw new \UnexpectedValueException(
                'Expected newval as TransformatorInterface, but provided ' . gettype($strategy)
            );
        }

        return parent::offsetSet($index, $strategy);
    }

    /**
     * Select strategy and transform locator to XPath
     *
     * @param string $locator
     * @return string
     */
    public function locator2Xpath($locator)
    {
        $match = [];
        preg_match('~^(([a-z]+)\=)?(.+)~', $locator, $match);
        return $this->offsetGet($match[2])->locator2Xpath($match[3]);
    }
}
