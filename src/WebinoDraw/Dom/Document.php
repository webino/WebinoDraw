<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Dom;

use DOMXpath;

/**
 * Extended DOMDocument
 */
class Document extends \DOMDocument
{
    /**
     * @var DOMXpath
     */
    protected $xpath;

    /**
     * @param string $version
     * @param string $encoding
     */
    public function __construct($version = null, $encoding = null)
    {
        parent::__construct($version, $encoding);
        $this->registerNodeClass('DOMElement', 'WebinoDraw\Dom\Element');
        $this->registerNodeClass('DOMText', 'WebinoDraw\Dom\Text');
        $this->registerNodeClass('DOMAttr', 'WebinoDraw\Dom\Attr');
    }

        /**
     * @return DOMXpath
     */
    public function getXpath()
    {
        if (null == $this->xpath) {
            $this->setXpath(new DOMXPath($this));
        }
        return $this->xpath;
    }

    /**
     * @param DOMXpath $xpath
     */
    public function setXpath(DOMXpath $xpath)
    {
        $this->xpath = $xpath;
        return $this;
    }

    /**
     * @return Element
     */
    public function getDocumentElement()
    {
        return $this->documentElement;
    }
}
