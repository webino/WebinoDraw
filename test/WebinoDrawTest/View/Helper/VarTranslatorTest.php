<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_View
 */

namespace WebinoDrawTest\View\Helper;

use WebinoDraw\View\Helper\VarTranslator;
use WebinoDrawTest\TestCase;

/**
 * Test class for WebinoDraw\View\Helper\VarTranslator.
 * 
 * @category    WebinoDraw
 * @package     WebinoDraw_View
 * @subpackage  UnitTests
 * @group       WebinoDraw_View
 * @group       WebinoDraw_View_Helper
 */
class VarTranslatorTest extends TestCase
{
    /**
     * @var WebinoDraw\View\Helper\VarTranslator
     */
    protected $varTranslator;

    protected function setUp()
    {
        $this->varTranslator = new VarTranslator($this->rendererMock);
    }

    public function testTranslateString()
    {
        $string      = 'before {$var} after';
        $expected    = 'before value after';
        $translation = array('{$var}' => 'value');
        $result      = $this->varTranslator->translateString($string, $translation);
        
        $this->assertEquals($expected, $result);
    }
    
    public function testTranslateStringArrayValue()
    {
        $string      = '{$var}';
        $expected    = array('value');
        $translation = array('{$var}' => $expected);
        $result      = $this->varTranslator->translateString($string, $translation);
        
        $this->assertEquals($expected, $result);
    }
}
