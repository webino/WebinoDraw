<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw\Helper;

use WebinoDraw\Dom\Attr;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\VarTranslator\Translation;
use WebinoDraw\View\Helper\EscapeHtmlTrait;
use Zend\I18n\Translator\TranslatorInterface;

/**
 * Class Translate
 */
class Translate extends Element
{
    use EscapeHtmlTrait;

    /**
     * Draw helper service name
     */
    const SERVICE = 'webinodrawtranslate';

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TranslatorInterface|object $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param TranslatorInterface $translator
     * @return $this
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
        return $this;
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     * @return $this
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $this->resetVarTranslation($spec);

        $remainNodes = $this->translateAttribNodes(
            $nodes,
            $this->resolveTextDomain($spec),
            $this->resolveLocale($spec)
        );

        if (empty($remainNodes)) {
            // return early when all nodes were attribs
            return $this;
        }

        return parent::drawNodes($nodes->create($remainNodes), $spec);
    }

    /**
     * @param string $value
     * @param Translation $varTranslation
     * @param array $spec
     * @return string
     */
    public function translateValue($value, Translation $varTranslation, array $spec)
    {
        $varValue = trim(parent::translateValue($value, $varTranslation, $spec));
        if (empty($varValue)) {
            return '';
        }

        return $this->translator->translate(
            $varValue,
            $this->resolveTextDomain($spec),
            $this->resolveLocale($spec)
        );
    }

    /**
     * @param NodeList $nodes
     * @param string $textDomain
     * @param string $locale
     * @return array
     */
    protected function translateAttribNodes(NodeList $nodes, $textDomain, $locale)
    {
        $escape = $this->getEscapeHtml();
        $remainNodes = [];

        foreach ($nodes as $node) {
            if ($node instanceof Attr && !$node->isEmpty()) {
                $node->nodeValue = $this->translator->translate($escape($node->nodeValue), $textDomain, $locale);
            }

            $remainNodes[] = $node;
        }

        return $remainNodes;
    }

    /**
     * @param array $spec
     * @return string
     */
    protected function resolveTextDomain(array $spec)
    {
        return !empty($spec['text_domain'])
               ? $this->getVarTranslation()->translateString($spec['text_domain'])
               : 'default';
    }

    /**
     * @param array $spec
     * @return string
     */
    protected function resolveLocale(array $spec)
    {
        return !empty($spec['locale'])
               ? $this->getVarTranslation()->translateString($spec['locale'])
               : null;
    }

    /**
     * @param array $spec
     * @return $this
     */
    private function resetVarTranslation(array $spec)
    {
        $varTranslation = $this->getVarTranslation();

        if (!empty($spec['text_domain']) && $varTranslation->containsVar($spec['text_domain'])) {
            $this->setVarTranslation(null);
            return $this;
        }

        if (!empty($spec['locale']) && $varTranslation->containsVar($spec['locale'])) {
            $this->setVarTranslation(null);
            return $this;
        }

        return $this;
    }
}
