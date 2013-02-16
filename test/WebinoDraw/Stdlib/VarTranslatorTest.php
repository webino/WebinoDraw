<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk/)
 * @license     New BSD License
 * @package     WebinoDraw\Stdlib
 */

namespace WebinoDraw\Stdlib;

/**
 * Test class for WebinoDraw\Stdlib\VarTranslator.
 *
 * @category    Webino
 * @package     WebinoDraw\Stdlib
 * @subpackage  UnitTests
 * @group       WebinoDraw\Stdlib
 * @author      Peter Bačinský <peter@bacinsky.sk>
 */
class VarTranslatorTest
    extends \PHPUnit_Framework_TestCase
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
