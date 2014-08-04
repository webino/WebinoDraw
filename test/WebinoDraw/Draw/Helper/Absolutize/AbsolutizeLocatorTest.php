<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw\Helper\Absolutize;

use WebinoDraw\Dom\Document;
use WebinoDraw\Dom\Locator;
use WebinoDraw\Dom\Locator\Transformator;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-08-03 at 02:40:53.
 */
class AbsolutizeLocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbsolutizeLocator
     */
    protected $object;

    /**
     *
     * @var Locator
     */
    protected $locator;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object  = new AbsolutizeLocator;
        $this->locator = new Locator(new Transformator);
    }

    /**
     * @covers WebinoDraw\Draw\Helper\Absolutize\AbsolutizeLocator::getLocator
     * @covers WebinoDraw\Draw\Helper\Absolutize\AbsolutizeLocator::getCondition
     */
    public function testGetDefaultLocator()
    {
        $dom = new Document;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->loadXML('<node src="test-src" href="test-href" action="test-action"/>');
        $locator    = $this->object->getLocator();

        $this->assertSame(
            $dom->documentElement->getAttributeNode('src'),
            $this->locator->locate($dom->documentElement, $locator)->item(0)
        );
        $this->assertSame(
            $dom->documentElement->getAttributeNode('href'),
            $this->locator->locate($dom->documentElement, $locator)->item(1)
        );
        $this->assertSame(
            $dom->documentElement->getAttributeNode('action'),
            $this->locator->locate($dom->documentElement, $locator)->item(2)
        );
    }

    /**
     * @covers WebinoDraw\Draw\Helper\Absolutize\AbsolutizeLocator::getLocator
     */
    public function testGetDefaultLocatorDoNoMatchHttp()
    {
        $dom     = new Document;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->loadXML('<node src="http://test-src" href="http://test-href" action="http://test-action"/>');
        $locator = $this->object->getLocator();

        $this->assertFalse((bool) $this->locator->locate($dom->documentElement, $locator)->length);
    }

    /**
     * @covers WebinoDraw\Draw\Helper\Absolutize\AbsolutizeLocator::getLocator
     */
    public function testGetDefaultLocatorDoNoMatchRelativeSharp()
    {
        $dom     = new Document;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->loadXML('<node src="#test-src" href="#test-href" action="#test-action"/>');
        $locator = $this->object->getLocator();

        $this->assertFalse((bool) $this->locator->locate($dom->documentElement, $locator)->length);
    }

    /**
     * @covers WebinoDraw\Draw\Helper\Absolutize\AbsolutizeLocator::getLocator
     */
    public function testGetDefaultLocatorDoNoMatchRelativeQueryParams()
    {
        $dom     = new Document;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->loadXML('<node src="?test-src" href="?test-href" action="?test-action"/>');
        $locator = $this->object->getLocator();

        $this->assertFalse((bool) $this->locator->locate($dom->documentElement, $locator)->length);
    }

    /**
     * @covers WebinoDraw\Draw\Helper\Absolutize\AbsolutizeLocator::getLocator
     */
    public function testGetDefaultLocatorDoNoMatchAbsolutePath()
    {
        $dom     = new Document;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->loadXML('<node src="/test-src" href="/test-href" action="/test-action"/>');
        $locator = $this->object->getLocator();

        $this->assertFalse((bool) $this->locator->locate($dom->documentElement, $locator)->length);
    }

    /**
     * @covers WebinoDraw\Draw\Helper\Absolutize\AbsolutizeLocator::getLocator
     */
    public function testGetDefaultLocatorDoNoMatchMailto()
    {
        $dom     = new Document;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->loadXML('<node src="mailto:test-src" href="mailto:test-href" action="mailto:test-action"/>');
        $locator = $this->object->getLocator();

        $this->assertFalse((bool) $this->locator->locate($dom->documentElement, $locator)->length);
    }

    /**
     * @covers WebinoDraw\Draw\Helper\Absolutize\AbsolutizeLocator::getLocator
     */
    public function testGetDefaultLocatorDoNoMatchJavascript()
    {
        $dom     = new Document;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->loadXML('<node src="javascript:test-src" href="javascript:test-href" action="javascript:test-action"/>');
        $locator = $this->object->getLocator();

        $this->assertFalse((bool) $this->locator->locate($dom->documentElement, $locator)->length);
    }

    /**
     * @covers WebinoDraw\Draw\Helper\Absolutize\AbsolutizeLocator::getLocator
     */
    public function testGetDefaultLocatorDoNoMatchDisabledAbsolutize()
    {
        $dom     = new Document;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->loadXML('<node src="test-src" href="test-href" action="test-action" data-webino-draw-absolutize="no"/>');
        $locator = $this->object->getLocator();

        $this->assertFalse((bool) $this->locator->locate($dom->documentElement, $locator)->length);
    }
}
