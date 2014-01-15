<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Dom\Locator;

class StrategyFactory
{
    const DEFAULT_STRATEGY = 'css';

    /**
     * Available strategies
     *
     * @var array
     */
    protected static $strategyList = array(
        'css'   => 'WebinoDraw\Dom\Locator\Strategy\CssStrategy',
        'xpath' => 'WebinoDraw\Dom\Locator\Strategy\XpathStrategy'
    );

    /**
     * @param string $type Strategy type
     * @return TransformatorInterface
     * @throws \OutOfBoundsException
     */
    public function createStrategy($type)
    {
        $strategy = $this->determineStrategy($type);

        if (empty(self::$strategyList[$strategy])) {
            throw new \OutOfBoundsException(
                'Dont\'t know strategy type ' . $strategy
            );
        }

        return new self::$strategyList[$strategy];
    }

    /**
     * Return provided or default strategy type
     *
     * @param string $type
     * @return string
     */
    protected function determineStrategy($type)
    {
        if (empty($type)) {
            return self::DEFAULT_STRATEGY;
        }

        return $type;
    }
}
