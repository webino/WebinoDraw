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

use PHPWebDriver_WebDriverBy as By;

/**
 *
 */
class HomeTest extends AbstractBase
{
    /**
     * Property to store the cached value
     */
    private static $cachedValue;

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

        // value
        $loc = 'Fork WebinoDraw on GitHub »';
        $elm = $this->session->element(By::LINK_TEXT, $loc);
        $this->assertEquals('https://github.com/webino/WebinoDraw', $elm->attribute('href'));
        // /value

        // html
        $loc = 'h1';
        $elm = $this->session->element(By::TAG_NAME, $loc);
        $this->assertEquals('Welcome to Webino', $elm->text());

        $loc = 'html-on-empty-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('HTML ON EMPTY', $elm->text());

        $loc = 'zf-green';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('Webino', $elm->text());
        // /html

        // replace
        $loc = 'replace-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('TEST REPLACE', $elm->text());
        // /replace

        // add
        $loc = '.jumbotron > span';
        $elm = $this->session->element(By::CSS_SELECTOR, $loc);
        $this->assertEquals('TEST ADD BEFORE', $elm->text());
        // //add

        // remove
        $loc = 'remove-me-single';
        $this->assertEquals(0, count($this->session->elements(By::CLASS_NAME, $loc)));

        $loc = 'remove-me';
        $this->assertEquals(0, count($this->session->elements(By::CLASS_NAME, $loc)));

        $loc = 'remove-me-xpath';
        $this->assertEquals(0, count($this->session->elements(By::CLASS_NAME, $loc)));
        // /remove

        // var
        $loc = 'h2[title="ORIGCONTENT NODEVARATTRIBTEST ORIGATTRIB"]';
        $elm = $this->session->element(By::CSS_SELECTOR, $loc);
        $this->assertEquals('ORIGCONTENT NODEVARTEST ORIGATTRIB', $elm->text());

        $loc = 'viewvar-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('TESTVIEWVAR DEPTHVAR', $elm->text());
        // /onVar

        // onVar
        $loc = 'on-var-equal-to-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('ON VAR VALUE EQUAL TO', $elm->text());

        $loc = 'on-var-not-equal-to-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('ON VAR VALUE NOT EQUAL TO', $elm->text());
        // /onVar

        // filter
        $loc = 'filter-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('THIS SHOULD BE UPPER CASE', $elm->text());
        // /filter

        // translate
        $loc = 'translate-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('toto by malo byť preložené', $elm->text());

        $loc = 'translate-draw-helper-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('toto by malo byť preložené cez draw helper', $elm->text());

        $loc = 'translate-draw-helper-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('toto by malo byť preložené cez draw helper', $elm->attribute('title'));
        // /translate

        // loop
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

        $loc = '.loop-empty-example.no-items';
        $elm = $this->session->element(By::CSS_SELECTOR, $loc);
        $this->assertEquals('YOU HAVE NO ITEMS', $elm->text());
        // /loop

        // form
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
        // /form

        // runtime
        $loc = 'runtime-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('RUNTIME EXAMPLE VALUE', $elm->text());
        // /runtime

        // event
        $loc = 'event-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals('EVENT EXAMPLE VALUE', $elm->text());
        // /event

        // subInstructions
        $loc = 'subinstructions-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertContains('SUB-INSTRUCTIONS(TEST) EXAMPLE VALUE', $elm->text());

        $loc = '.subinstructions-example > form.example-form > label > span';
        $elm = $this->session->element(By::CSS_SELECTOR, $loc);
        $this->assertEquals('Ukážka popisky*(TEST)', $elm->text());

        $loc = '//*[@class="subinstructions-example"]/form[@class="example-form"]/label[2]/span';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('Label example2*(TEST)', $elm->text());
        // /subInstructions

        // TODO test ajax
        // ajax
        $ajaxTime = $this->session->element(By::ID, 'ajax-time')->text();
        $this->assertNotEmpty($ajaxTime);

        $ajaxRand = $this->session->element(By::ID, 'ajax-rand')->text();
        $this->assertNotEmpty($ajaxRand);

        // click ajax
        $loc = '//*[@class="ajax-example"]/a[1]';
        $elm = $this->session->element(By::XPATH, $loc);
        $elm->click();
        $this->waitForAjax();

        $ajaxTime2 = $this->session->element(By::ID, 'ajax-time')->text();
        $this->assertNotEmpty($ajaxTime2);

        $ajaxRand2 = $this->session->element(By::ID, 'ajax-rand')->text();
        $this->assertNotEmpty($ajaxRand2);

        $this->assertNotEquals($ajaxTime, $ajaxTime2);
        $this->assertNotEquals($ajaxRand, $ajaxRand2);

        // click ajax single
        $loc = '//*[@class="ajax-example"]/a[2]';
        $elm = $this->session->element(By::XPATH, $loc);
        $elm->click();
        $this->waitForAjax();

        $ajaxTime3 = $this->session->element(By::ID, 'ajax-time')->text();
        $this->assertNotEmpty($ajaxTime3);
        $this->assertEquals($ajaxTime2, $ajaxTime3);

        $ajaxRand3 = $this->session->element(By::ID, 'ajax-rand')->text();
        $this->assertNotEmpty($ajaxRand3);
        $this->assertNotEquals($ajaxRand2, $ajaxRand3);

        // click ajax extra
        $loc = '//*[@class="ajax-example"]/a[3]';
        $elm = $this->session->element(By::XPATH, $loc);
        $elm->click();
        $this->waitForAjax();

        $ajaxTime4 = $this->session->element(By::ID, 'ajax-time')->text();
        $this->assertNotEmpty($ajaxTime4);
        $this->assertNotEquals($ajaxTime3, $ajaxTime4);

        $ajaxRand4 = $this->session->element(By::ID, 'ajax-rand')->text();
        $this->assertNotEmpty($ajaxRand4);
        $this->assertNotEquals($ajaxRand3, $ajaxRand4);

        $loc = 'ajax-log';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertStringStartsWith('ajax extra random ', $elm->text());
        // /ajax

        // cache
        $loc = 'cache-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this::$cachedValue = $elm->text();
        $this->assertStringStartsWith('CACHED? ', $this::$cachedValue);
        // /cache

        // custom-helper
        $loc = 'custom-helper-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertContains('VALUE FROM CUSTOM HELPER', $elm->text());

        $loc = 'custom-di-helper-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertContains('VALUE FROM CUSTOM DI HELPER', $elm->text());
        // /custom-helper

        // pagination
        // TODO do not use ?1 on the first page by default
        $loc = '//*[@class="pagination-example"]/ul/li[1]/a[@href="?1"]';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('«', $elm->text());

        // TODO do not use ?1 on the first page by default
        $loc = '//*[@class="pagination-example"]/ul/li[2]/a[@href="?1"]';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('1', $elm->text());

        $loc = '//*[@class="pagination-example"]/ul/li[3]/a[@href="?2"]';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('2', $elm->text());

        $loc = '//*[@class="pagination-example"]/ul/li[4]/a[@href="?3"]';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('3', $elm->text());

        $loc = '//*[@class="pagination-example"]/ul/li[5]/a[@href="?3"]';
        $elm = $this->session->element(By::XPATH, $loc);
        $this->assertEquals('»', $elm->text());
        // /pagination
    }

    /**
     *
     */
    public function testCache()
    {
        $this->session->open($this->uri);
        $this->assertNotContains('Server Error', $this->session->title());

        $loc = 'cache-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertEquals($this::$cachedValue, $elm->text());

        // clear cache test
        $this->session->open($this->uri . '?clearcache');
        $this->assertNotContains('Server Error', $this->session->title());

        $loc = 'cache-example';
        $elm = $this->session->element(By::CLASS_NAME, $loc);
        $this->assertNotEmpty($elm->text());
        $this->assertNotEquals($this::$cachedValue, $elm->text());
        $this::$cachedValue = null;
    }
}
