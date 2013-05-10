<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk/)
 * @license     New BSD License
 */

namespace Application\Controller;

use WebinoDraw\AjaxEvent;
use WebinoDraw\DrawEvent;
use WebinoDraw\DrawFormEvent;
use Zend\I18n\Translator\TextDomain;
use Zend\I18n\Translator\Loader\RemoteLoaderInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\AbstractValidator;

/**
 * WebinoDraw  test application controller.
 */
class IndexController extends AbstractActionController implements RemoteLoaderInterface
{
    /**
     * Test translation
     *
     * @param  string $locale
     * @param  string $textDomain
     * @return TextDomain|null
     */
    public function load($locale, $textDomain)
    {
        return new TextDomain(
            array(
                'this should be translated' => 'toto by malo byť preložené',
                'Label example' => 'Ukážka popisky',
            )
        );
    }

    /**
     * Use case examples
     *
     * @return array
     */
    public function indexAction()
    {
        // setup test translator
        /* @var $translator \Zend\I18n\Translator\Translator */
        $translator = $this->getServiceLocator()->get('translator');
        $translator->getPluginManager()->setService('testTranslation', $this);
        $translator->addRemoteTranslations('testTranslation', 'test');
        $translator->setLocale('sk_SK');
        AbstractValidator::setDefaultTranslator($translator);
        // /setup test translator

        // trigger form errors
        $form = $this->getServiceLocator()->get('exampleForm');
        $form->setData(array('test'));
        $form->isValid();

        // 1) set instructions into the draw strategy
        $this->getServiceLocator()->get('WebinoDraw')->setInstructions(
            array(
                'direct-example' => array(
                    'value' => '{$_value} VALUE',
                ),
            )
        );

        // 2) attach example-event listener to the draw element custom event
        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            'event-example.test',
            function(DrawEvent $event) {

                $event->getNodes()
                    ->setAttribs(array('style' => 'border: 1px solid #ee0000;'));

                $event->setSpec(
                    array(
                        'value'   => '{$_value} VALUE',
                        'attribs' => array(
                            'title' => 'Hello from Controller!',
                        ),
                    )
                );
            }
        );

        // 3) attach form-example.event listener to the draw form custom event
        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            'form-example.event',
            function(DrawFormEvent $event) {

                $event->getNodes()
                    ->setAttribs(array('style' => 'border: 1px solid #0000ee;'));

                $event->getForm()->add(
                    array(
                        'name' => 'element_from_controller',
                        'attributes' => array(
                            'type'  => 'submit',
                            'value' => 'Button from controller',
                        ),
                    )
                );

                $event->getForm()
                    ->setData(array('example_text_element' => 'TEST VALUE FROM CONTROLLER'));

                $event->setSpec(
                    array(
                        'instructions' => array(
                            'instruction-from-controller' => array(
                                'locator' => 'input',
                                'attribs' => array(
                                    'disabled' => 'disabled',
                                    'title' => 'Form sub-instruction title from controller',
                                ),
                            ),
                        ),
                    )
                );
            }
        );

        // 4) attach listener to the ajax event
        $request = $this->request;
        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            AjaxEvent::EVENT_AJAX,
            function(AjaxEvent $event) use ($request) {

                !$request->getQuery()->offsetExists('ajaxExtra') or
                    $event->setJson(array('extraTest' => 'ajax extra random ' . rand()));

                $id = $request->getQuery()->fragmentId;
                if (empty($id)) {
                    return;
                }

                $event->setFragmentXpath('//*[@id="' . $id . '"]');
            }
        );

        // 5) clear the draw cache example
        !isset($this->request->getQuery()->clearcache) or
            $this->getServiceLocator()->get('WebinoDrawCache')->clearByTags(array('example'));

        // test view variables
        return array(

            'viewvar' => 'TESTVIEWVAR',

            'value' => array(
                'in' => array(
                    'the' => array(
                        'depth' => 'DEPTHVAR',
                    ),
                ),
            ),

            'depth' => array(
                'items' => array(
                    'itemToOffset' => array(
                        'property0' => 'value0ToOffset',
                        'property1' => 'value1ToOffset',
                    ),
                    'item0' => array(
                        'property0' => 'value00',
                        'property1' => 'value01',
                        'childs'    => array(
                            'item00' => array(
                                'property0' => 'value000',
                                'property1' => 'value001',
                            ),
                            'item01' => array(
                                'property0' => 'value010',
                                'property1' => 'value011',
                            ),
                        ),
                    ),
                    'item1' => array(
                        'property0' => 'value10',
                        'property1' => 'value11',
                    ),
                    'item3' => array(
                        'property0' => 'value30',
                        'property1' => 'value31',
                    ),
                    'itemTooMuch' => array(
                        'property0' => 'value0TooMuch',
                        'property1' => 'value1TooMuch',
                    ),
                ),
            ),
        );
    }

    /**
     *
     */
    public function saveAction()
    {
        $this->redirect()->toUrl($this->request->getBaseUrl());
    }
}
