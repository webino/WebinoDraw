<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace Application\Controller;

use WebinoDraw\AjaxEvent;
use WebinoDraw\DrawEvent;
use WebinoDraw\DrawFormEvent;
use Zend\I18n\Translator\TextDomain;
use Zend\I18n\Translator\Loader\RemoteLoaderInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator;
use Zend\Validator\AbstractValidator;
use Zend\View\Model\ViewModel;

/**
 * WebinoDraw application test controller
 */
class IndexController extends AbstractActionController implements RemoteLoaderInterface
{
    /**
     * Test translation
     *
     * @param  string $locale
     * @param  string $textDomain
     * @return TextDomain
     */
    public function load($locale, $textDomain)
    {
        return new TextDomain([
            'this should be translated' => 'toto by malo byť preložené',
            'this should be translated by draw helper' => 'toto by malo byť preložené cez draw helper',
            'Label example' => 'Ukážka popisky',
        ]);
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
        $form->setData(['test']);
        $form->isValid();

        // setup test paginator
        $this->getServiceLocator()->setService(
            'WebinoDrawPaginator',
            (new Paginator\Paginator(
                new Paginator\Adapter\ArrayAdapter([[], [], [], [], []])
            ))->setItemCountPerPage(2)
        );
        // /setup test paginator

        // 1) set instructions into the draw strategy
        $this->getServiceLocator()->get('WebinoDraw')->setInstructions([
            'runtime-example' => [
                'value' => '{$_nodeValue} VALUE',
            ],
            'runtime-example-x' => [
                'value' => '{$_nodeValue} VALUE',
            ],
        ]);

        // 2) attach example-event listener to the draw element custom event
        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            'event-example.test',
            function (DrawEvent $event) {

                $event->getNodes()
                    ->setAttribs(['style' => 'border: 1px solid #ee0000;']);

                $event->setSpec([
                    'value' => '{$_nodeValue} VALUE',
                    'attribs' => [
                        'title' => 'Hello from Controller!',
                    ],
                ]);
            }
        );

        // 3) attach form-example.event listener to the draw form custom event
        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            'form-example.event',
            function (DrawFormEvent $event) {

                $event->getNodes()
                    ->setAttribs(['style' => 'border: 1px solid #0000ee;']);

                $event->getForm()->add([
                    'name' => 'element_from_controller',
                    'attributes' => [
                        'type'  => 'submit',
                        'value' => 'Button from controller',
                    ],
                ]);

                $event->getForm()
                    ->setData(['example_text_element' => 'TEST VALUE FROM CONTROLLER']);

                $event->setSpec([
                    'instructions' => [
                        'instruction-from-controller' => [
                            'locator' => 'input',
                            'attribs' => [
                                'disabled' => 'disabled',
                                'title'    => 'Form sub-instruction title from controller',
                            ],
                        ],
                    ],
                ]);
            }
        );

        // 4) attach listener to the ajax event
        $request = $this->request;
        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            AjaxEvent::EVENT_AJAX,
            function (AjaxEvent $event) use ($request) {

                !$request->getQuery()->offsetExists('ajaxExtra') or
                    $event->setJson(['extraTest' => 'ajax extra random ' . rand()]);

                $id = $request->getQuery()->fragmentId;
                if (empty($id)) {
                    return;
                }

                $event->setFragmentXpath('//*[@id="' . $id . '"]');
            }
        );

        // 5) clear the draw cache example
        !isset($this->request->getQuery()->clearcache) or
            $this->getServiceLocator()->get('WebinoDrawCache')->clearByTags(['example']);

        // test view variables
        return [
            'viewvar' => 'TESTVIEWVAR',
            'value' => [
                'in' => [
                    'the' => [
                        'depth' => 'DEPTHVAR',
                    ],
                ],
            ],
            'depth' => [
                'items' => [
                    'itemToOffset' => [
                        'property0' => 'value0ToOffset',
                        'property1' => 'value1ToOffset',
                    ],
                    'item0' => [
                        'property0' => 'value00',
                        'property1' => 'value01',
                        'childs'    => [
                            'item00' => [
                                'property0' => 'value000',
                                'property1' => 'value001',
                            ],
                            'item01' => [
                                'property0' => 'value010',
                                'property1' => 'value011',
                            ],
                        ],
                    ],
                    'item1' => [
                        'property0' => 'value10',
                        'property1' => 'value11',
                    ],
                    'item3' => [
                        'property0' => 'value30',
                        'property1' => 'value31',
                    ],
                    'itemTooMuch' => [
                        'property0' => 'value0TooMuch',
                        'property1' => 'value1TooMuch',
                    ],
                ],
            ],
        ];
    }

    /**
     * Form dummy postback
     */
    public function saveAction()
    {
        $this->redirect()->toUrl($this->request->getBaseUrl());
    }

    /**
     * Heavy testing
     *
     * @return string
     */
    public function heavyAction()
    {
        $draw = $this->getServiceLocator()->get('WebinoDraw');
        $draw->setInstructions([
            'long-list' => [
                'locator'   => '.long-list',
                'cache'     => 'long-list',

                'instructions' => [
                    'item' => [
                        'locator' => 'li',
                        'value'   => '{$_index} {$text}',

                        'loop' => [
                            'base' => 'long_list',
                        ],
                    ],
                ],
            ],
        ]);

        // generate data
        $data = [];

        $text = 'Paš glouskůřenchlym niděk člobleď. Frc hrýš, tišlý pa chénizli tiškeš v fla děďmo '
                . 'choněr nivrýtlutat flyhlaž z mláď, vlireměh lkusteněm niništ a dibu i tes břetěm '
                . 'tiz škázly, di vu pypřouflel lápi hrgý kůn mymrůs niti k cháčnýzdleni a děslům. '
                . 'Glo tkesliti. Z těk těsak třizra člihreskni? Ni mevoď deš dihly dir slamrá gluni, '
                . 'zlýmlýjžré zluza uhřižlyj žletiv z tiďa v běchrou, mloj puzku ufluptoz nimi '
                . 'mipochroň slamu těbu, sech umepr o úbyl šlouží di tě mloumani. Bedic tymo s dini '
                . 'šrur. Dipěv i diď. Mleva a ti, gloněť stůjni glysk nyplýklech jetrou nizkuj '
                . 'a žragre. I ňorá tra dře paštaběn clys sini? Zoř žlůšké i bří šlicku, pyh úně '
                . 'glíhá a těvo kapeti.';

        $data['long_list'] = [];

        for ($i=0; $i < 500; $i++) {
            $data['long_list'][] = ['text' => $text];
        }

        return $data;
    }

    /**
     * Xml testing
     *
     * @return string
     */
    public function xmlAction()
    {
        $draw = $this->getServiceLocator()->get('WebinoDraw');
        $draw->setInstructions([
            'cdata-example' => [
                'locator' => 'cdataExample',
                'cdata'   => '<p>CDATA EXAMPLE</p>',
            ],
            'cdata-on-empty-example' => [
                'locator' => 'cdataOnEmptyExample',
                'cdata'   => '',

                'onEmpty' => [
                    'locator' => 'xpath=.',
                    'cdata'   => '<p>CDATA ON EMPTY EXAMPLE</p>',
                ],
            ],
        ]);

        $this->getResponse()->getHeaders()
            ->addHeaderLine('Content-Type', 'text/xml;charset=utf-8');

        return (new ViewModel)->setTerminal(true);
    }
}
