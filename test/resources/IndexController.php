<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk/)
 * @license     New BSD License
 */

namespace Application\Controller;

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
     * @return \Zend\I18n\Translator\TextDomain|null
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

    public function indexAction()
    {
        // Set instructions into the draw strategy
        $this->getServiceLocator()->get('ViewDrawStrategy')->setInstructions(array(
            'direct-example' => array(
                'value' => '{$nodeValue} VALUE',
            ),
        ));

        // Attach example-event listener to the draw element custom event
        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            'event-example.test',
            function($event) {
                $event->setSpec(
                    array(
                        'value'   => '{$nodeValue} VALUE',
                        'attribs' => array(
                            'title' => 'Hello from Controller!',
                        ),
                    )
                );
            }
        );

        // Attach form-example.event listener to the draw form custom event
        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            'form-example.event',
            function($event) {

                $event->getParam('form')
                    ->setData(array('example_text_element' => 'TEST VALUE FROM CONTROLLER'));

                $event->setSpec(
                    array(
                        'instructions' => array(
                            'instruction-from-controller' => array(
                                'query' => 'input',
                                'helper' => 'drawElement',
                                'attribs' => array(
                                    'title' => 'Form sub-instruction title from controller',
                                ),
                            ),
                        ),
                    )
                );
            }
        );

        // Set up test translator
        /* @var $translator \Zend\I18n\Translator\Translator */
        $translator = $this->getServiceLocator()->get('translator');
        $translator->getPluginManager()->setService('testTranslation', $this);
        $translator->addRemoteTranslations('testTranslation', 'test');

        $translator->setLocale('sk_SK');

        AbstractValidator::setDefaultTranslator($translator);

        $form = $this->getServiceLocator()->get('exampleForm');
        $form->setData(array('test'));
        $form->isValid();

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
                ),
            ),
        );
    }

    public function saveAction()
    {
        $this->redirect()->toUrl($this->request->getBaseUrl());
    }
}
