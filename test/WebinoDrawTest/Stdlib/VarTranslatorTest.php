<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_Stdlib
 */

namespace WebinoDrawTest\Stdlib;

use WebinoDraw\Stdlib\VarTranslator;
use WebinoDrawTest\TestCase;

/**
 * Test class for WebinoDraw\Stdlib\VarTranslator.
 *
 * @category    Webino
 * @package     WebinoDraw_Stdlib
 * @subpackage  UnitTests
 * @group       WebinoDraw_Stdlib
 */
class VarTranslatorTest extends TestCase
{
    /**
     * @var WebinoDraw\Stdlib\VarTranslator
     */
    protected $varTranslator;

    /**
     * Zend\
     *
     * @var type
     */
    protected $pluginHelperMock;

    protected function setUp()
    {
        $this->pluginHelperMock = $this->getMock('Zend\ServiceManager\AbstractPluginManager');
        $this->varTranslator    = new VarTranslator($this->pluginHelperMock);
    }

    public function testTranslateString()
    {
        $string      = 'before {$var} after';
        $expected    = 'before value after';
        $translation = array('{$var}' => 'value');
        $result      = $this->varTranslator->translateString($string, $translation);

        $this->assertEquals($expected, $result);
    }
}
