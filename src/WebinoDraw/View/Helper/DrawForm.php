<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_View
 */

namespace WebinoDraw\View\Helper;

use WebinoDraw\Exception;
use WebinoDraw\Dom\NodeList;
use WebinoDraw\Stdlib\DrawInstructions;
use WebinoDraw\View\Helper\AbstractDrawElement;
use Zend\Form\FormInterface;
use Zend\Form\View\Helper\FormCollection;
use Zend\Form\View\Helper\FormRow;
use Zend\I18n\View\Helper\AbstractTranslatorHelper as BaseAbstractHelper;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Draw helper used to render form.
 *
 * @category    Webino
 * @package     WebinoDraw_View
 * @subpackage  Helper
 */
class DrawForm extends AbstractDrawElement implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    protected $formCollectionHelper;

    protected $formRowHelper;

    protected $formElementHelper;

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function getFormCollectionHelper()
    {
        if (empty($this->formCollectionHelper)) {

            $formCollection = $this->view->plugin('formCollection')
                                ->setElementHelper($this->getFormRowHelper());

            $this->setFormCollectionHelper($formCollection);
        }

        return $this->formCollectionHelper;
    }

    public function setFormCollectionHelper(FormCollection $formCollection)
    {
        $this->formCollectionHelper = $formCollection;
        return $this;
    }

    public function getFormRowHelper()
    {
        if (empty($this->formRowHelper)) {

            $formRow = $this->view->plugin('magicFormRow')
                        ->setElementHelper($this->getFormElementHelper());

            $this->setFormRowHelper($formRow);
        }

        return $this->formRowHelper;
    }

    public function setFormRowHelper(FormRow $formRow)
    {
        $this->formRowHelper = $formRow;
        return $this;
    }

    public function getFormElementHelper()
    {
        if (empty($this->formElementHelper)) {

            $this->setFormElementHelper(
                $this->view->plugin('magicFormElement')
            );
        }

        return $this->formElementHelper;
    }

    public function setFormElementHelper(BaseAbstractHelper $formElement)
    {
        $this->formElementHelper = $formElement;
        return $this;
    }

    public function createForm(array $spec)
    {
        if (empty($spec['form'])) {

            throw new Exception\RuntimeException(
                sprintf('Expected form option in: %s', print_r($spec, 1))
            );
        }

        try {

            $form = $this->serviceLocator->getServiceLocator()->get($spec['form']);

        } catch (\Exception $e) {

            throw new Exception\RuntimeException(
                sprintf('Expected form in: %s; ' . $e->getMessage(), print_r($spec, 1)),
                $e->getCode(), $e
            );
        }

        if (isset($spec['route'])) {
            try {

                $form->setAttribute('action', $this->view->url($spec['route']));

            } catch (\Exception $e) {

                throw new Exception\RuntimeException(
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
     * Draw nodes in list.
     *
     * @param \WebinoDraw\Dom\NodeList $nodes
     * @param array $spec
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $form = $this->createForm($spec);
        $translation = $this->getVars();

        !array_key_exists('trigger', $spec) or
            $spec = $this->trigger($nodes, $spec, $form);

        $nodes->setAttribs($form->getAttributes());

        isset($spec['text_domain']) or $spec['text_domain'] = 'default';
        $this->setTranslatorTextDomain($spec['text_domain']);

        foreach ($nodes as $node) {

            $childNodes = $nodes->createNodeList(array($node));

            if (empty($node->childNodes->length)) {
                // easy render
                $formCollection = $this->getFormCollectionHelper();

                $childNodes->setHtml($formCollection($form));

            } else {
                $this->matchTemplate($childNodes, $form->getElements());
            }

            foreach ($childNodes as $childNode) {
                if (!empty($spec['instructions'])) {
                    DrawInstructions::render(
                       $childNode,
                       $this->view,
                       $spec['instructions'],
                       $translation
                   );
                }
            }
        }
    }

    protected function setTranslatorTextDomain($textDomain = 'default')
    {
        $this->getFormRowHelper()->setTranslatorTextDomain($textDomain);
        $this->getFormElementHelper()->setTranslatorTextDomain($textDomain);

        return $this;
    }

    /**
     * Try to match form elements to template
     *
     * @param \WebinoDraw\Dom\NodeList $nodes
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

    public function trigger(NodeList $nodes, array $spec, FormInterface $form)
    {
        $event = $this->getEvent();

        $event->setSpec($spec);
        $event->setParam('form', $form);

        foreach ($nodes as $node) {

            $event->setNode($node);

            foreach ($spec['trigger'] as $eventName) {
                $this->getEventManager()->trigger($eventName, $event);
            }
        }

        return $event->getSpec();
    }
}
