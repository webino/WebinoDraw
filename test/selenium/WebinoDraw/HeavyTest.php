<?php

namespace WebinoDraw;

use PHPWebDriver_WebDriverBy as By;

class HeavyTest extends AbstractBase
{
    /**
     *
     */
    public function testHeavy()
    {
        $this->session->open($this->uri . 'heavy');
        $this->assertNotContains('Server Error', $this->session->title());

        $this->session->element(By::XPATH, '//li[500]');
    }
}
