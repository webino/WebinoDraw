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

use WebinoDraw\Event\DrawFormEvent;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Exception;
use WebinoDraw\Instructions\InstructionsRenderer;
use Zend\Form\FormInterface;
use Zend\Form\View\Helper\FormCollection;
use WebinoDraw\Form\View\Helper\FormElement;
use Zend\Form\View\Helper\FormElementErrors;
use Zend\Form\View\Helper\FormRow;
use Zend\View\Helper\Url;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Draw helper used to render the form
 *
 * @todo redesign
 */
class Form extends AbstractHelper
{
    /**
     * Draw helper service name
     */
    const SERVICE = 'webinodrawform';

    /**
     * @var DrawFormEvent
     */
    private $formEvent;

    /**
     * @var ServiceLocatorInterface
     */
    protected $forms;

    /**
     * @var FormRow
     */
    protected $formRow;

    /**
     * @var FormElement
     */
    protected $formElement;

    /**
     * @var FormElementErrors
     */
    protected $formElementErrors;

    /**
     * @var FormCollection
     */
    protected $formCollection;

    /**
     * @var Url
     */
    protected $url;

    /**
     * @var InstructionsRenderer
     */
    protected $instructionsRenderer;

    /**
     * @todo redesign
     * @param ServiceLocatorInterface $forms
     * @param FormRow $formRow
     * @param FormElement $formElement
     * @param FormElementErrors $formElementErrors
     * @param FormCollection $formCollection
     * @param Url $url
     * @param InstructionsRenderer $instructionsRenderer
     */
    public function __construct(
        ServiceLocatorInterface $forms,
        FormRow $formRow,
        FormElement $formElement,
        FormElementErrors $formElementErrors,
        FormCollection $formCollection,
        Url $url,
        InstructionsRenderer $instructionsRenderer
    ) {
        $this->forms                = $forms;
        $this->formRow              = $formRow;
        $this->formElement          = $formElement;
        $this->formElementErrors    = $formElementErrors;
        $this->formCollection       = $formCollection;
        $this->url                  = $url;
        $this->instructionsRenderer = $instructionsRenderer;
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     */
    public function __invoke(NodeList $nodes, array $spec)
    {
        $event = $this->getFormEvent();
        $event
            ->setHelper($this)
            ->clearSpec()
            ->setSpec($spec)
            ->setNodes($nodes);

        $cache = $this->getCache();
        if ($cache->load($event)) {
            return;
        }

        $form = $this->createForm($spec);
        $event->setForm($form);

        array_key_exists('trigger', $spec)
            and $this->trigger($spec['trigger'], $event);

        $this->drawNodes($nodes, $event->getSpec()->getArrayCopy());
        $cache->save($event);
    }

    /**
     * @return DrawFormEvent
     */
    public function getFormEvent()
    {
        if (null === $this->formEvent) {
            $this->setFormEvent(new DrawFormEvent);
        }
        return $this->formEvent;
    }

    /**
     * @param DrawFormEvent $event
     * @return $this
     */
    public function setFormEvent(DrawFormEvent $event)
    {
        $this->formEvent = $event;
        return $this;
    }

    /**
     * @param string $textDomain
     * @return $this
     */
    public function setTranslatorTextDomain($textDomain = 'default')
    {
        $this->formRow->setTranslatorTextDomain($textDomain);
        $this->formElement->setTranslatorTextDomain($textDomain);
        return $this;
    }

    /**
     * @param bool $bool
     * @return $this
     */
    public function setRenderErrors($bool = true)
    {
        $this->formRow->setRenderErrors($bool);
        return $this;
    }

    /**
     * @param array $spec
     * @return FormInterface
     * @throws Exception\RuntimeException
     */
    protected function createForm(array $spec)
    {
        if (empty($spec['form'])) {
            throw new Exception\RuntimeException(
                sprintf('Expected form option in: %s', print_r($spec, true))
            );
        }

        try {
            $form = clone $this->forms->get($spec['form']);
        } catch (\Exception $exc) {
            throw new Exception\RuntimeException(
                sprintf('Expected form in: %s; ' . $exc->getMessage(), print_r($spec, true)),
                $exc->getCode(),
                $exc
            );
        }

        if (!($form instanceof FormInterface)) {
            throw new Exception\LogicException('Expected form of type FormInterface');
        }

        if (isset($spec['route'])) {
            try {
                $routeFormAction = $this->resolveRouteFormAction($spec['route']);
            } catch (\Exception $exc) {
                throw new Exception\RuntimeException(
                    $exc->getMessage() . sprintf(' for %s', print_r($spec, true)),
                    $exc->getCode(),
                    $exc
                );
            }

            $form->setAttribute('action', $routeFormAction);
        }

        if (!empty($spec['populate'])) {
            $this->translate($spec['populate']);
            $form->populateValues($spec['populate']);
        }

        return $form;
    }

    /**
     * @param string|array $spec
     * @return string
     * @throws Exception\InvalidArgumentException
     * @throws Exception\RuntimeException
     */
    protected function resolveRouteFormAction($spec)
    {
        if (!is_string($spec) && !is_array($spec)) {
            throw new Exception\InvalidArgumentException('Expected string or array');
        }

        $route = is_array($spec) ? $spec : ['name' => $spec];

        if (empty($route['name'])) {
            throw new Exception\RuntimeException('Expected route name option');
        }

        $params  = !empty($route['params']) ? $route['params'] : [];
        $options = !empty($route['options']) ? $route['options'] : [];
        $reusedMatchedParams = !empty($route['reuseMatchedParams']) ? $route['reuseMatchedParams'] : [];

        try {
            $routeFormAction = $this->url->__invoke(
                $route['name'],
                $params,
                $options,
                $reusedMatchedParams
            );

        } catch (\Exception $exc) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Expected route `%s`',
                    $route['name']
                ),
                $exc->getCode(),
                $exc
            );
        }

        return $routeFormAction;
    }

    /**
     * @todo refactor
     *
     * @param NodeList $nodes
     * @param array $spec
     * @return $this
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $form = $this->getFormEvent()->getForm();

        // set form attributes without class,
        // it will be appended later
        $formAttribs = (array) $form->getAttributes();
        $formClass   = '';
        if (isset($formAttribs['class'])) {
            $formClass = $formAttribs['class'];
            unset($formAttribs['class']);
        }
        $nodes->setAttribs($formAttribs);

        isset($spec['wrap'])
            or $spec['wrap'] = false;

        isset($spec['text_domain'])
            or $spec['text_domain'] = 'default';

        $this->setTranslatorTextDomain($spec['text_domain']);

        // defer sub-instructions
        $subInstructions = !empty($spec['instructions']) ? $spec['instructions'] : [];
        unset($spec['instructions']);
        parent::drawNodes($nodes, $spec);

        array_key_exists('render_errors', $spec)
            and $this->setRenderErrors($spec['render_errors']);

        $translation = $this->getVarTranslator()->createTranslation($this->getVars());
        foreach ($nodes as $node) {

            // append the form class to the node class
            $node->setAttribute('class', trim($node->getAttribute('class') . ' ' . $formClass));

            $childNodes = $nodes->create([$node]);
            if (empty($node->childNodes->length)) {
                // easy render
                $childNodes->setHtml($this->formCollection->__invoke($form, $spec['wrap']));
            } else {
                $this->matchTemplate($childNodes, $form);
            }

            $this->instructionsRenderer->expandInstructions($spec, $translation);
            if (!empty($subInstructions)) {
                foreach ($childNodes as $childNode) {
                    // sub-instructions
                    $this->instructionsRenderer
                        ->subInstructions(
                            [$childNode],
                            $subInstructions,
                            $translation
                        );
                }
            }
        }

        return $this;
    }

    // TODO DrawFormRenderer
    // todo decouple & redesign
    protected function matchTemplate(NodeList $nodes, FormInterface $form)
    {
        // todo injection
        $translator = $this->formRow->getTranslator();

        $matched  = [];
        $toRemove = [];
        $elements = $form->getElements();

        /* @var $node \WebinoDraw\Dom\Element */
        foreach ($nodes as $node) {
            /** @var \WebinoDraw\Dom\Document $ownerDocument */
            $ownerDocument = $node->ownerDocument;

            $nodePath = $node->getNodePath();
            $elementNodes = $ownerDocument->getXpath()->query('.//*[@name]', $node);
            /* @var $elementNode \WebinoDraw\Dom\Element */
            foreach ($elementNodes as $elementNode) {

                $elementName = $elementNode->getAttribute('name');
                $matched[$elementName] = true;

                if (!$form->has($elementName)) {
                    // remove node of the missing form element
                    $parentNode = $elementNode->parentNode;
                    if ('label' === $parentNode->nodeName) {
                        $parentNode->parentNode->removeChild($parentNode);
                    } else {
                        $toRemove[$nodePath][] = $elementName;
                        $elementNode->parentNode->removeChild($elementNode);
                    }
                    continue;
                }

                $elementNode->setAttribute('id', $elementName);

                /* @var $element \Zend\Form\Element */
                $element    = $form->get($elementName);
                $attributes = $element->getAttributes();

                // TODO remaining elements
                if (isset($attributes['type'])) {
                    switch ($attributes['type']) {
                        case 'checkbox':
                            /* @var $element \Zend\Form\Element\Checkbox */
                            $attributes['value'] = $element->getCheckedValue();
                            // todo checkbox use hidden element
                            break;
                        case 'multi_checkbox':
                            $multiNode = $ownerDocument->createDocumentFragment();
                            $multiNode->appendXml($this->formRow->__invoke($element));
                            $elementNode = $elementNode->parentNode->replaceChild($multiNode, $elementNode);
                            unset($multiNode);
                            break;
                        case 'select':
                            $selectNode = $ownerDocument->createDocumentFragment();
                            $selectNode->appendXml($this->formElement->__invoke($element));
                            $newNode = $selectNode->firstChild;
                            $elementNode->parentNode->replaceChild($newNode, $elementNode);
                            $elementNode = $newNode;
                            unset($selectNode);
                            unset($newNode);
                            break;

                        case 'text':
                        case 'email':
                        case 'submit':
                        case 'reset':
                        case 'button':

                            // set element node value if available
                            $value = $elementNode->hasAttribute('value')
                                ? $elementNode->getAttribute('value')
                                : $element->getValue();

                            $attributes['value'] = !empty($value) ? $translator->translate($value) : '';
                            unset($value);
                            break;
                    }
                }

                // glue form & template element class
                empty($attributes['class'])
                    or $attributes['class'] = trim($attributes['class'] . ' ' . $elementNode->getAttribute('class'));

                $subElementNodes = $nodes->create([$elementNode]);
                $subElementNodes->setAttribs($attributes);

                // labels
                $subElementNodes->each(
                    'xpath=../span[name(..)="label"]|..//label[@for="' . $elementName . '"]',
                    function ($nodes) use ($element, $translator) {
                        $label = $translator->translate($element->getLabel());

                        /* @var $subNode \WebinoDraw\Dom\Element */
                        foreach ($nodes as $subNode) {
                            $subNode->nodeValue = !$subNode->isEmpty()
                                ? $translator->translate($subNode->nodeValue)
                                : $label;
                        }
                    }
                );

                // errors
                $messages = $element->getMessages();
                if (!empty($messages)) {

                    $errorNode = $ownerDocument->createDocumentFragment();
                    $errorNode->appendXml($this->formElementErrors->__invoke($element));

                    foreach ($subElementNodes as $subElementNode) {
                        if (empty($subElementNode->nextSibling)) {
                            $subElementNode->parentNode->appendChild($errorNode);
                        } else {
                            $subElementNode->parentNode->insertBefore($errorNode, $subElementNode);
                        }
                    }
                }
            }

            // auto draw hidden nodes
            /** @var \Zend\Form\Element $element */
            foreach ($elements as $element) {
                $attributes = $element->getAttributes();
                if (empty($attributes['type'])
                    || 'hidden' !== $attributes['type']
                ) {
                    continue;
                }

                // skip matched elements
                if (isset($matched[$attributes['name']])) {
                    continue;
                }

                $hiddenNode = $ownerDocument->createDocumentFragment();
                $xhtml      = (string) $this->formRow->__invoke($element);

                $hiddenNode->appendXml($xhtml);
                if (!$hiddenNode->hasChildNodes()) {
                    throw new Exception\RuntimeException('Invalid XHTML ' . $xhtml);
                }
                $node->appendChild($hiddenNode);
            }
        }

        // remove labels of missing elements
        foreach ($toRemove as $nodePath => $elementNames) {
            foreach ($elementNames as $elementName) {
                $nodes->remove('xpath=' . $nodePath . '//label[@for="' . $elementName . '"]');
            }
        }
    }
}
