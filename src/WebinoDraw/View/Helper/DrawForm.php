<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Helper;

use WebinoDraw\DrawEvent;
use WebinoDraw\DrawFormEvent;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Exception\RuntimeException;
use Zend\Form\FormInterface;
use Zend\Form\View\Helper\FormCollection;
use Zend\Form\View\Helper\FormRow;
use Zend\I18n\View\Helper\AbstractTranslatorHelper;

/**
 * Draw helper used to render the form
 */
class DrawForm extends AbstractDrawHelper
{
    /**
     * @var FormCollection
     */
    protected $formCollectionHelper;

    /**
     * @var FormRow
     */
    protected $formRowHelper;

    /**
     * @var AbstractTranslatorHelper
     */
    protected $formElementHelper;

    public function getView()
    {
        if (null === $this->view) {
            throw new \RuntimeException('Expected view');
        }
        return $this->view;
    }

    /**
     * Get the attached event
     *
     * Will create a new Event if none provided.
     *
     * @return DrawFormEvent
     */
    public function getEvent()
    {
        if (null === $this->event) {
            $this->setEvent(new DrawFormEvent);
        }
        return $this->event;
    }

    /**
     * Set an event to use
     *
     * @param  DrawFormEvent $event
     * @return void
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
     * @return FormCollection
     */
    public function getFormCollectionHelper()
    {
        if (empty($this->formCollectionHelper)) {

            $formCollection = $this->view->plugin('WebinoDrawFormCollection')
                                ->setElementHelper($this->getFormRowHelper());

            $this->setFormCollectionHelper($formCollection);
        }

        return $this->formCollectionHelper;
    }

    /**
     * @param FormCollection $helper
     * @return DrawForm
     */
    public function setFormCollectionHelper(FormCollection $helper)
    {
        $this->formCollectionHelper = $helper;
        return $this;
    }

    /**
     * @return FormRow
     */
    public function getFormRowHelper()
    {
        if (empty($this->formRowHelper)) {

            $formRow = $this->getView()->plugin('WebinoDrawFormRow')
                        ->setElementHelper($this->getFormElementHelper());

            $this->setFormRowHelper($formRow);
        }

        return $this->formRowHelper;
    }

    /**
     * @param FormRow $helper
     * @return DrawForm
     */
    public function setFormRowHelper(FormRow $helper)
    {
        $this->formRowHelper = $helper;
        return $this;
    }

    /**
     * @return AbstractTranslatorHelper
     */
    public function getFormElementHelper()
    {
        if (empty($this->formElementHelper)) {
            $this->setFormElementHelper(
                $this->getView()->plugin('WebinoDrawFormElement')
            );
        }

        return $this->formElementHelper;
    }

    /**
     * @param AbstractTranslatorHelper $helper
     * @return DrawForm
     */
    public function setFormElementHelper(AbstractTranslatorHelper $helper)
    {
        $this->formElementHelper = $helper;
        return $this;
    }

    /**
     * @param string $textDomain
     * @return DrawForm
     */
    public function setTranslatorTextDomain($textDomain = 'default')
    {
        $this->getFormRowHelper()->setTranslatorTextDomain($textDomain);
        $this->getFormElementHelper()->setTranslatorTextDomain($textDomain);
        return $this;
    }

    public function setRenderErrors($bool = true)
    {
        $this->getFormRowHelper()->setRenderErrors($bool);
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
                sprintf('Expected form option in: %s', print_r($spec, 1))
            );
        }

        try {
            $form = $this->serviceLocator->getServiceLocator()->get($spec['form']);

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

        $route = is_array($spec) ? $spec : array('name' => $spec);

        if (empty($route['name'])) {
            throw new RuntimeException('Expected route name option');
        }

        $params  = !empty($route['params']) ? $route['params'] : array();
        $options = !empty($route['options']) ? $route['options'] : array();
        $reusedMatchedParams = !empty($route['reuseMatchedParams']) ? $route['reuseMatchedParams'] : array();

        try {
            $routeFormAction = $this->view->url(
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
     * @param NodeList $nodes
     * @param array $spec
     */
    public function __invoke(NodeList $nodes, array $spec)
    {
        if ($this->cacheLoad($nodes, $spec)) {
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

        $this->drawNodes($nodes, $event->getSpec()->getArrayCopy());

        $this->cacheSave($nodes, $spec);
    }

    /**
     * @todo refactor
     *
     * @param NodeList $nodes
     * @param array $spec
     * @return DrawForm
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
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

            $childNodes = $nodes->createNodeList(array($node));

            if (empty($node->childNodes->length)) {
                // easy render
                $formCollection = $this->getFormCollectionHelper();

                $childNodes->setHtml($formCollection($form, $spec['wrap']));

            } else {
                $this->matchTemplate($childNodes, $form);
            }

            $this->expandInstructionsFromSet($spec);

            if (!empty($spec['instructions'])) {

                foreach ($childNodes as $childNode) {

                    $this
                        ->cloneInstructionsPrototype($spec['instructions'])
                        ->render(
                            $childNode,
                            $this->view,
                            $translation->getArrayCopy()
                        );
                }
            }
        }

        return $this;
    }

    // todo decouple & redesign
    protected function matchTemplate(NodeList $nodes, FormInterface $form)
    {
        $elements   = $form->getElements();
        $translator = $this->getFormElementHelper()->getTranslator();

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
                $hiddenNode->appendXml($this->view->formRow($element));
                $node->appendChild($hiddenNode);
            }

            $elementNodes = $node->ownerDocument->xpath->query(
                './/*[@name]',
                $node
            );

            $nodePath = $node->getNodePath();
            $toRemove = array();
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
                        case 'multi_checkbox':
                        case 'select':
                            $selectNode = $node->ownerDocument->createDocumentFragment();
                            $selectNode->appendXml($this->view->formRow($element));
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

                $elementNodes = $nodes->createNodeList(array($elementNode));
                $elementNodes->setAttribs($attributes);

                // labels
                $elementNodes->each(
                    'xpath=../span[name(..)="label"]|..//label[@for="' . $elementName . '"]',
                    function ($nodes) use ($element, $translator) {
                        $nodes->setValue(
                            $translator->translate($element->getLabel())
                        );
                    }
                );

                // errors
                $messages = $element->getMessages();
                if (!empty($messages)) {

                    $errorNode = $node->ownerDocument->createDocumentFragment();
                    $errorNode->appendXml($this->view->formElementErrors($element));

                    foreach ($elementNodes as $elementNode) {

                        if (empty($elementNode->nextSibling)) {
                            $elementNode->parentNode->appendChild($errorNode);
                        } else {
                            $elementNode->parentNode->insertBefore(
                                $errorNode,
                                $elementNode
                            );
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
