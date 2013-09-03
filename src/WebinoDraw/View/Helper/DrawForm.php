<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
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
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Draw helper used to render the form
 */
class DrawForm extends AbstractDrawHelper implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

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
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
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
                $exc->getCode(), $exc
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
        }

        $formAction = !empty($routeFormAction) ? $routeFormAction : null;
        $form->setAttribute('action', $formAction);

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
        $formClass   = $formAttribs['class'];
        unset($formAttribs['class']);
        $nodes->setAttribs($formAttribs);

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

                $childNodes->setHtml($formCollection($form));

            } else {
                $this->matchTemplate($childNodes, $form->getElements());
            }

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

    /**
     * Try to match form elements to template
     *
     * @param NodeList $nodes
     * @param array $elements
     */
    protected function matchTemplate(NodeList $nodes, array $elements)
    {
        foreach ($nodes as $node) {

            /* @var $element \Zend\Form\Element */
            foreach ($elements as $element) {

                $elementName = $element->getName();
                $attributes  = $element->getAttributes();

                $childNodes = $node->ownerDocument->xpath->query(
                    './/*[@name="' . $elementName . '"]',
                    $node
                );

                if (isset($attributes['type'])
                    && 'hidden' == $attributes['type']
                ) {
                    $hiddenNode = $node->ownerDocument->createDocumentFragment();

                    $hiddenNode->appendXml($this->view->formRow($element));

                    $childNodes = array($node->appendChild($hiddenNode));
                    continue;
                }

                if (!count($childNodes)) {
                    // element not found
                    continue;
                }

                $elementNodes = $nodes->createNodeList($childNodes);
                $elementNodes->setAttribs($attributes);

                $messages = $element->getMessages();

                if (!empty($messages)) {

                    $errorNode = $node->ownerDocument->createDocumentFragment();

                    $errorNode->appendXml($this->view->formElementErrors($element));

                    foreach ($elementNodes as $elementNode) {

                        if (empty($elementNode->nextSibling)) {

                            $elementNode->parentNode->appendChild($errorNode);

                        } else {

                            $elementNode->parentNode->insertBefore(
                                $errorNode->nextSibling,
                                $elementNode
                            );
                        }
                    }
                }
            }
        }
    }
}
