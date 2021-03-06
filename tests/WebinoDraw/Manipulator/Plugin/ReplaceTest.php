<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Manipulator\Plugin;

use WebinoDraw\Dom\Document;
use WebinoDraw\VarTranslator\Translation;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-08-02 at 13:41:09.
 */
class ReplaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Replace
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Replace;
    }

    /**
     * @covers WebinoDraw\Manipulator\Plugin\Replace::inLoop
     */
    public function testReplace()
    {
        $dom        = new Document;
        $dom->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $dom->loadXML('<node/>');

        $html           = '<testhtmlreplace __nodeId="be7041b0dd010418c9ebb055b2f7b86f"/>';
        $spec           = ['replace' => $html];
        $helper         = $this->getMock('WebinoDraw\Draw\Helper\AbstractHelper');
        $varTranslation = new Translation;

        $helper
            ->expects($this->once())
            ->method('translateValue')
            ->with($html, $varTranslation)
            ->will($this->returnValue($html));

        $arg = new PluginArgument([
            'node'           => $dom->firstChild,
            'spec'           => $spec,
            'helper'         => $helper,
            'translation'    => new Translation,
            'varTranslation' => $varTranslation,
        ]);

        $this->object->inLoop($arg);

        $this->assertEquals($html, $dom->firstChild->getOuterHtml());
        $this->assertFalse((bool) $dom->getElementsByTagName('node')->length);
    }
}
