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

            $formCollection = $this->view->plugin('formCollection')
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

            $formRow = $this->view->plugin('WebinoDrawFormRow')
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
                $this->view->plugin('WebinoDrawFormElement')
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

        } catch (\Exception $e) {

            throw new RuntimeException(
                sprintf('Expected form in: %s; ' . $e->getMessage(), print_r($spec, 1)),
                $e->getCode(), $e
            );
        }

        if (isset($spec['route'])) {
            try {

                $form->setAttribute('action', $this->view->url($spec['route']));

            } catch (\Exception $e) {

                throw new RuntimeException(
                    sprintf(
                        'Expected route `%s` for %s',
                        $spec['route'],
                        print_r($spec, 1)
                    ),
                    $e->getCode(),
                    $e
                );
            }
        } else {
            $form->setAttribute('action', null);
        }

        return $form;
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        if ($this->cacheLoad($nodes, $spec)) {
            return;
        }

        $form  = $this->createForm($spec);
        $event = $this->getEvent();

        $event->clearSpec()
            ->setSpec($spec)
            ->setNodes($nodes)
            ->setForm($form);

        !array_key_exists('trigger', $spec) or
            $this->trigger($spec['trigger']);

        $this->doWork($nodes, $form, $event->getSpec()->getArrayCopy());

        $this->cacheSave($nodes, $spec);
    }

    /**
     * @param NodeList $nodes
     * @param FormInterface $form
     * @param array $spec
     * @return DrawForm
     */
    protected function doWork(NodeList $nodes, FormInterface $form, array $spec)
    {
        $nodes->setAttribs($form->getAttributes());

        isset($spec['text_domain'])
            or $spec['text_domain'] = 'default';
        
        $this->setTranslatorTextDomain($spec['text_domain']);

        $translation = $this->cloneTranslationPrototype($this->getVars());

        foreach ($nodes as $node) {

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
