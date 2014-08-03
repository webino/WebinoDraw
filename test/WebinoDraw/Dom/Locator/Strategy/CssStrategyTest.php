<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Dom\Locator\Strategy;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-09-06 at 20:12:57.
 */
class CssStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CssStrategy
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new CssStrategy;
    }

    /**
     * @covers WebinoDraw\Dom\Locator\Strategy\CssStrategy::locator2Xpath
     */
    public function testLocator2XpathRelative()
    {
        $locator  = '.class-name';
        $expected = ".//*[contains(concat(' ', normalize-space(@class), ' '), ' class-name ')]";
        $result   = $this->object->locator2Xpath($locator);

        $this->assertSame($expected, $result);
    }

    /**
     * @covers WebinoDraw\Dom\Locator\Strategy\CssStrategy::locator2Xpath
     */
    public function testLocator2XpathAbsolute()
    {
        $locator  = '//.class-name';
        $expected = "//*[contains(concat(' ', normalize-space(@class), ' '), ' class-name ')]";
        $result   = $this->object->locator2Xpath($locator);

        $this->assertSame($expected, $result);
    }
}
