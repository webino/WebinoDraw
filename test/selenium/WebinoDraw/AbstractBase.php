<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

use PHPWebDriver_WebDriver;
use RuntimeException;

/**
 *
 */
abstract class AbstractBase extends \PHPUnit_Framework_TestCase
{
    /**
     * Selenium Web Driver Host URI
     */
    const WEB_DRIVER_HOST = 'http://localhost:4444/wd/hub';

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var PHPWebDriver_WebDriver
     */
    protected $webDriver;

    /**
     * @var PHPWebDriver_WebDriverSession
     */
    protected $session;

    /**
     *
     */
    public function setUp()
    {
        $this->uri       = $this->resolveUri();
        $this->webDriver = new PHPWebDriver_WebDriver(self::WEB_DRIVER_HOST);
        $this->session   = $this->webDriver->session('htmlunit');
    }

    /**
     *
     */
    public function tearDown()
    {
        $this->session->close();
    }

    /**
     * Resolve test target URI
     *
     * @return string
     */
    public function resolveUri()
    {
        $uri = getenv('URI');
        if (empty($uri)) {
            throw new RuntimeException('Expected URI env');
        }

        return $uri;
    }

    /**
     * Ajax wait
     */
    protected function waitForAjax()
    {
        do {
            sleep(2);
        } while ($this->session->execute(['script' => 'return jQuery.active', 'args' => []]));
    }
}
