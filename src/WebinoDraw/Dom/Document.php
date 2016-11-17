<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Dom;

use DOMXpath;
use WebinoDraw\Exception;

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
        $this->registerNodeClass('DOMElement', Element::class);
        $this->registerNodeClass('DOMText', Text::class);
        $this->registerNodeClass('DOMAttr', Attr::class);
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
     * @return $this
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

    /**
     * @param string $source
     * @param array|null $options
     * @return bool
     */
    public function loadHTML($source, $options = null)
    {
        // hack HTML5
        $errors = libxml_use_internal_errors();
        libxml_use_internal_errors(true);
        $markup = mb_convert_encoding($source, 'HTML-ENTITIES', 'UTF-8');
        $result = parent::loadHTML($markup, LIBXML_COMPACT | $options);
        libxml_use_internal_errors($errors);
        return $result;
    }
}
