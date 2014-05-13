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

use WebinoDraw\Ajax\FragmentXpath;
use WebinoDraw\Ajax\Json;
use Zend\EventManager\Event;

/**
 *
 */
class AjaxEvent extends Event
{
    /**#@+
     * Ajax events
     */
    const EVENT_AJAX = 'ajax';
    /**#@-*/

    /**
     * @var Json
     */
    protected $json;

    /**
     * @var FragmentXpath
     */
    protected $fragmentXpath;

    /**
     * @return Json
     */
    public function getJson()
    {
        if (null === $this->json) {
            $this->setJson(new Json);
        }
        return $this->json;
    }

    /**
     * @param array|Json $json
     * @return DrawEvent
     */
    public function setJson($json)
    {
        if (is_array($json)) {

            $this->json = $this->getJson();
            $this->setParam('json', $this->json);
            $this->json->merge($json);
            return $this;
        }

        if ($json instanceof Json) {

            $this->setParam('json', $json);
            $this->json = $json;
            return $this;
        }

        throw new \UnexpectedValueException(
            'Expected array|Json'
        );
    }

    /**
     * @return FragmentXpath
     */
    public function getFragmentXpath()
    {
        if (null === $this->fragmentXpath) {
            $this->setFragmentXpath(new FragmentXpath);
        }
        return $this->fragmentXpath;
    }

    /**
     * @param string|FragmentXpath $xpath
     * @return DrawEvent
     */
    public function setFragmentXpath($xpath)
    {
        if (is_string($xpath)) {

            $this->fragmentXpath = $this->getFragmentXpath();
            $this->setParam('fragmentXpath', $this->fragmentXpath);
            $this->fragmentXpath->set($xpath);
            return $this;
        }

        if ($xpath instanceof FragmentXpath) {

            $this->setParam('fragmentXpath', $xpath);
            $this->fragmentXpath = $xpath;
            return $this;
        }

        throw new \UnexpectedValueException(
            'Expected string|FragmentXpath'
        );
    }
}
