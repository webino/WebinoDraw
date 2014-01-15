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
        $loc = '//head/script[contains(@src, "/test-script-relative.js")]';
        $this->session->element(By::XPATH, $loc);

        $loc = '//head/link[contains(@href, "/test-link-relative.css")]';
        $this->session->element(By::XPATH, $loc);

        $loc = '//body/form[contains(@action, "/test-action-relative")]';
        $this->session->element(By::XPATH, $loc);
        // /absolutize


        $loc = 'h1';
        $elm = $this->session->element(By::TAG_NAME, $loc);
        $this->assertEquals('Welcome to Webino', $elm->text());

        $loc = 'zf-green';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('Webino', $elm->text());

        $loc = '.jumbotron > span';
        $elm = $this->session->element(By::CSS_SELECTOR, $loc);
        $this->assertEquals('TEST ADD BEFORE', $elm->text());

        $loc = 'strong';
        $elm = $this->session->element(By::TAG_NAME, $loc);
        $this->assertEquals('TEST REPLACE', $elm->text());

        $loc = 'Fork WebinoDraw on GitHub »';
        $this->session->element(By::LINK_TEXT, $loc);

        $loc = 'remove-me-single';
        $this->assertEquals(0, count($this->session->elements(By::CLASS_NAME, $loc)));

        $loc = 'remove-me';
        $this->assertEquals(0, count($this->session->elements(By::CLASS_NAME, $loc)));

        $loc = 'remove-me-xpath';
        $this->assertEquals(0, count($this->session->elements(By::CLASS_NAME, $loc)));

        $loc = 'h2[title="ORIGCONTENT NODEVARATTRIBTEST ORIGATTRIB"]';
        $elm = $this->session->element(By::CSS_SELECTOR, $loc);
        $this->assertEquals('ORIGCONTENT NODEVARTEST ORIGATTRIB', $elm->text());

        $loc = 'viewvar-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('TESTVIEWVAR DEPTHVAR', $elm->text());

        $loc = 'filter-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('THIS SHOULD BE UPPER CASE', $elm->text());

        $loc = 'translate-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('toto by malo byť preložené', $elm->text());

        $loc = 'ul.loop-example > li:first-child';
        $elm = $this->session->element(By::CSS_SELECTOR, $loc);
        $this->assertEquals('BEFORE', $elm->text());

        $loc = 'li[title="value1ToOffset"] > strong';
        $elm = $this->session->elements(By::CSS_SELECTOR, $loc);
        $this->assertEquals(0, count($elm));

        $loc = '//li[2][@title="value01"]/strong';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('item0 1 value00 value000', $elm->text());

        $loc = '//li[2][@title="value01"]/span';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('TADA', $elm->text());

        $loc = '//li[3][@title="value11"]/strong';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('item1 2 value10', $elm->text());

        $loc = '//li[3][@title="value11"]/span';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('TADA', $elm->text());

        $loc = '//li[4][@title="value31"]/strong';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('item3 3 value30', $elm->text());

        $loc = '//li[4][@title="value31"]/span';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('TADA', $elm->text());

        $loc = 'li[title="value1TooMuch"] > strong';
        $elm = $this->session->elements(By::CSS_SELECTOR, $loc);
        $this->assertEquals(0, count($elm));

        $loc = '//ul[@class="loop-example"]/li[5]';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('AFTER', $elm->text());

        $loc = '//p[4]';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('YOU HAVE NO ITEMS', $elm->text());

        $loc = 'label span';
        $elm = $this->session->element(By::CSS_SELECTOR, $loc);
        $this->assertEquals('Ukážka popisky', $elm->text());

        $loc = 'example_text_element';
        $elm = $this->session->element(By::NAME, $loc);
        $this->assertEquals('TEST VALUE FROM CONTROLLER', $elm->attribute("value"));

        $loc = 'form.example-form > ul > li';
        $elm = $this->session->element(By::CSS_SELECTOR, $loc);
        $this->assertEquals('Položka je povinná a nesmie byť prázdna', $elm->text());

        $loc = '//label[2]/span';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('Label example2', $elm->text());

        $loc = 'runtime-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('RUNTIME EXAMPLE VALUE', $elm->text());

        $loc = 'event-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('EVENT EXAMPLE VALUE', $elm->text());

        $loc = 'subinstructions-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertContains('SUB-INSTRUCTIONS(TEST) EXAMPLE VALUE', $elm->text());

        $loc = '.subinstructions-example > form.example-form > label > span';
        $elm = $this->session->element(By::CSS_SELECTOR, $loc);
        $this->assertEquals('Ukážka popisky*(TEST)', $elm->text());

        $loc = '//div[4]/form/label[2]/span';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('Label example2*(TEST)', $elm->text());
    }
}
