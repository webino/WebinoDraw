<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Draw\Helper;

use WebinoDraw\Event\DrawEvent;
use WebinoDraw\Event\DrawFormEvent;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Exception\RuntimeException;
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

    protected $instructionsRenderer;

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
     */
    public function __invoke(NodeList $nodes)
    {
        $spec = $this->getSpec();
        if ($this->cacheLoad($nodes)) {
            return;
        }

        $form  = $this->createForm($spec);
        $event = $this->getEvent();

        $event->clearSpec()
            ->setHelper($this)
            ->setSpec($spec)
            ->setNodes($nodes)
            ->setForm($form);

        !array_key_exists('trigger', $spec) or
            $this->trigger($spec['trigger']);

        $this
            ->setSpec($event->getSpec()->getArrayCopy())
            ->drawNodes($nodes)
            ->cacheSave($nodes, $spec);
    }

    /**
     * @return selfEvent
     */
    public function getEvent()
    {
        if (null === $this->event) {
            $this->setEvent(new DrawFormEvent);
        }
        return $this->event;
    }

    /**
     * @param DrawFormEvent $event
     */
    public function setEvent(DrawEvent $event)
    {
        if (!($event instanceof DrawFormEvent)) {
            throw new \UnexpectedValueException(
                'Expect DrawFormEvent but provided ' . get_class($event)
            );
        }

        $this->event = $event;
        return $this;
    }

    /**
     * @param string $textDomain
     * @return self
     */
    public function setTranslatorTextDomain($textDomain = 'default')
    {
        $this->formRow->setTranslatorTextDomain($textDomain);
        $this->formElement->setTranslatorTextDomain($textDomain);
        return $this;
    }

    public function setRenderErrors($bool = true)
    {
        $this->formRow->setRenderErrors($bool);
        return $this;
    }

    /**
     * @param array $spec
     * @return FormInterface
     * @throws RuntimeException
     */
    protected function createForm(array $spec)
    {
        if (empty($spec['form'])) {
            throw new RuntimeException(
                sprintf('Expected form option in: %s', print_r($spec, true))
            );
        }

        try {
            $form = $this->forms->get($spec['form']);

        } catch (\Exception $exc) {
            throw new RuntimeException(
                sprintf('Expected form in: %s; ' . $exc->getMessage(), print_r($spec, 1)),
                $exc->getCode(),
                $exc
            );
        }

        if (isset($spec['route'])) {
            try {
                $routeFormAction = $this->resolveRouteFormAction($spec['route']);

            } catch (\Exception $exc) {
                throw new RuntimeException(
                    $exc->getMessage()
                    . sprintf(
                        ' for %s',
                        print_r($spec, true)
                    ),
                    $exc->getCode(),
                    $exc
                );
            }

            $form->setAttribute('action', $routeFormAction);
        }

        return $form;
    }

    /**
     * @param string|array $spec
     * @return string
     * @throws \InvalidArgumentException
     * @throws RuntimeException
     */
    protected function resolveRouteFormAction($spec)
    {
        if (!is_string($spec)
            && !is_array($spec)
        ) {
            throw new \InvalidArgumentException('Expected string or array');
        }

        $route = is_array($spec) ? $spec : ['name' => $spec];

        if (empty($route['name'])) {
            throw new RuntimeException('Expected route name option');
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
            throw new RuntimeException(
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
     * @return self
     */
    public function drawNodes(NodeList $nodes)
    {
        $spec = $this->getSpec();
        $form = $this->getEvent()->getForm();

        // set form attributes without class,
        // it will be appended later
        $formAttribs = $form->getAttributes();
        $formClass   = '';
        if (!empty($formAttribs['class'])) {
            $formClass = $formAttribs['class'];
            unset($formAttribs['class']);
        }
        $nodes->setAttribs($formAttribs);

        isset($spec['wrap'])
            or $spec['wrap'] = false;

        isset($spec['text_domain'])
            or $spec['text_domain'] = 'default';

        $this->setTranslatorTextDomain($spec['text_domain']);

        !array_key_exists('render_errors', $spec) or
                $this->setRenderErrors($spec['render_errors']);

        $translation = $this->cloneTranslationPrototype($this->getVars());
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

            $this->instructionsRenderer->expandInstructions($spec);
            if (!empty($spec['instructions'])) {
                foreach ($childNodes as $childNode) {
                    // subinstructions
                    $this->instructionsRenderer
                        ->subInstructions(
                            [$childNode],
                            $spec['instructions'],
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

        $elements = $form->getElements();
        foreach ($nodes as $node) {

            // auto draw hidden nodes
            foreach ($elements as $element) {

                $attributes = $element->getAttributes();
                if (empty($attributes['type'])
                    || 'hidden' !== $attributes['type']
                ) {
                    continue;
                }

                $hiddenNode = $node->ownerDocument->createDocumentFragment();
                $xhtml      = (string) $this->formRow->__invoke($element);

                $hiddenNode->appendXml($xhtml);
                if (!$hiddenNode->hasChildNodes()) {
                    throw new \RuntimeException('Invalid XHTML ' . $xhtml);
                }
                $node->appendChild($hiddenNode);
            }

            $elementNodes = $node->ownerDocument->xpath->query('.//*[@name]', $node);

            $nodePath = $node->getNodePath();
            $toRemove = [];
            /* @var $element \Zend\Form\Element */
            foreach ($elementNodes as $elementNode) {

                $elementName = $elementNode->getAttribute('name');
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

                $element    = $form->get($elementName);
                $attributes = $element->getAttributes();

                // TODO
                if (isset($attributes['type'])) {
                    switch ($attributes['type']) {
                        case 'checkbox':
                            $attributes['value'] = $element->getCheckedValue();
                            // todo checkbox use hidden element
                            break;
                        case 'multi_checkbox':
                        case 'select':
                            $selectNode = $node->ownerDocument->createDocumentFragment();
                            $selectNode->appendXml($this->formRow->__invoke($element));
                            $elementNode = $elementNode->parentNode->replaceChild($selectNode, $elementNode);
                            unset($selectNode);
                            break;

                        case 'text':
                        case 'email':
                        case 'submit':
                        case 'reset':
                        case 'button':
                            $value = $element->getValue();
                            $attributes['value'] = !empty($value) ? $translator->translate($value) : '';
                            unset($value);
                            break;
                    }
                }

                $elementNodes = $nodes->create([$elementNode]);
                $elementNodes->setAttribs($attributes);

                // labels
                $elementNodes->each(
                    'xpath=../span[name(..)="label"]|..//label[@for="' . $elementName . '"]',
                    function ($nodes) use ($element, $translator) {
                        $nodes->setValue($translator->translate($element->getLabel()));
                    }
                );

                // errors
                $messages = $element->getMessages();
                if (!empty($messages)) {
                    $errorNode = $node->ownerDocument->createDocumentFragment();
                    $errorNode->appendXml($this->formElementErrors->__invoke($element));

                    foreach ($elementNodes as $elementNode) {
                        if (empty($elementNode->nextSibling)) {
                            $elementNode->parentNode->appendChild($errorNode);
                        } else {
                            $elementNode->parentNode->insertBefore($errorNode, $elementNode);
                        }
                    }
                }
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
