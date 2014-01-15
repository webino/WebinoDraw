<?php

namespace WebinoDraw;

use PHPWebDriver_WebDriverBy as By;

class HomeTest extends AbstractBase
{
    /**
     *
     */
    public function testHome()
    {
        $this->session->open($this->uri);
        $this->assertNotContains('Server Error', $this->session->title());

        // absolutize
        $this->session->element(By::XPATH, '//head/script[contains(@src, "/test-script-relative.js")]');
        $this->session->element(By::XPATH, '//head/link[contains(@href, "/test-link-relative.css")]');
        $this->session->element(By::XPATH, '//body/form[contains(@action, "/test-action-relative")]');
        // /absolutize

        //
        $elm = $this->session->element(By::TAG_NAME, 'h1');
        $this->assertEquals('Welcome to Webino', $elm->text());
        //
        $elm = $this->session->element(By::CLASS_NAME, 'zf-green');
        $this->assertEquals('Webino', $elm->text());
        //
        $elm = $this->session->element(By::CSS_SELECTOR, '.jumbotron > span');
        $this->assertEquals('TEST ADD BEFORE', $elm->text());
        //
        $elm = $this->session->element(By::TAG_NAME, 'strong');
        $this->assertEquals('TEST REPLACE', $elm->text());
        //
        $this->session->element(By::LINK_TEXT, 'Fork WebinoDraw on GitHub »');
        //
        $this->assertEquals(0, count($this->session->elements(By::CLASS_NAME, 'remove-me-single')));
        //
        $this->assertEquals(0, count($this->session->elements(By::CLASS_NAME, 'remove-me')));
        //
        $this->assertEquals(0, count($this->session->elements(By::CLASS_NAME, 'remove-me-xpath')));
        //
        $elm = $this->session->element(By::CSS_SELECTOR, 'h2[title="ORIGCONTENT NODEVARATTRIBTEST ORIGATTRIB"]');
        $this->assertEquals('ORIGCONTENT NODEVARTEST ORIGATTRIB', $elm->text());
        //
        $elm = $this->session->element(By::CLASS_NAME, 'viewvar-example');
        $this->assertEquals('TESTVIEWVAR DEPTHVAR', $elm->text());
        //
        $elm = $this->session->element(By::CLASS_NAME, 'filter-example');
        $this->assertEquals('THIS SHOULD BE UPPER CASE', $elm->text());
        //
        $elm = $this->session->element(By::CLASS_NAME, 'translate-example');
        $this->assertEquals('toto by malo byť preložené', $elm->text());
        //
        $elm = $this->session->element(By::CSS_SELECTOR, 'ul.loop-example > li:first-child');
        $this->assertEquals('BEFORE', $elm->text());
        //
        $this->assertEquals(0, count($this->session->elements(By::CSS_SELECTOR, 'li[title="value1ToOffset"] > strong')));
        //
        $elm = $this->session->element(By::XPATH, '//li[2][@title="value01"]/strong');
        $this->assertEquals('item0 1 value00 value000', $elm->text());
        //
        $elm = $this->session->element(By::XPATH, '//li[2][@title="value01"]/span');
        $this->assertEquals('TADA', $elm->text());
        //
        $elm = $this->session->element(By::XPATH, '//li[3][@title="value11"]/strong');
        $this->assertEquals('item1 2 value10', $elm->text());
        //
        $elm = $this->session->element(By::XPATH, '//li[3][@title="value11"]/span');
        $this->assertEquals('TADA', $elm->text());
        //
        $elm = $this->session->element(By::XPATH, '//li[4][@title="value31"]/strong');
        $this->assertEquals('item3 3 value30', $elm->text());
        //
        $elm = $this->session->element(By::XPATH, '//li[4][@title="value31"]/span');
        $this->assertEquals('TADA', $elm->text());
        //
        $this->assertEquals(0, count($this->session->elements(By::CSS_SELECTOR, 'li[title="value1TooMuch"] > strong')));
        //
        $elm = $this->session->element(By::XPATH, '//ul[@class="loop-example"]/li[5]');
        $this->assertEquals('AFTER', $elm->text());
        //
        $elm = $this->session->element(By::XPATH, '//p[4]');
        $this->assertEquals('YOU HAVE NO ITEMS', $elm->text());
        //
        $elm = $this->session->element(By::CSS_SELECTOR, 'label span');
        $this->assertEquals('Ukážka popisky', $elm->text());
        //
        $elm = $this->session->element(By::NAME, 'example_text_element');
        $this->assertEquals('TEST VALUE FROM CONTROLLER', $elm->attribute("value"));
        //
        $elm = $this->session->element(By::CSS_SELECTOR, 'form.example-form > ul > li');
        $this->assertEquals('Položka je povinná a nesmie byť prázdna', $elm->text());
        //
        $elm = $this->session->element(By::XPATH, '//label[2]/span');
        $this->assertEquals('Label example2', $elm->text());
        //
        $elm = $this->session->element(By::CLASS_NAME, 'runtime-example');
        $this->assertEquals('RUNTIME EXAMPLE VALUE', $elm->text());
        //
        $elm = $this->session->element(By::CLASS_NAME, 'event-example');
        $this->assertEquals('EVENT EXAMPLE VALUE', $elm->text());
        //
        $elm = $this->session->element(By::CLASS_NAME, 'subinstructions-example');
        $this->assertContains('SUB-INSTRUCTIONS(TEST) EXAMPLE VALUE', $elm->text());
        //
        $elm = $this->session->element(By::CSS_SELECTOR, '.subinstructions-example > form.example-form > label > span');
        $this->assertEquals('Ukážka popisky*(TEST)', $elm->text());
        //
        $elm = $this->session->element(By::XPATH, '//div[4]/form/label[2]/span');
        $this->assertEquals('Label example2*(TEST)', $elm->text());
    }
}
