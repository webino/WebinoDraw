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
                'runtime-example' => array(
                    'value' => '{$_nodeValue} VALUE',
                ),
            )
        );

        // 2) attach example-event listener to the draw element custom event
        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            'event-example.test',
            function (DrawEvent $event) {

                $event->getNodes()
                    ->setAttribs(array('style' => 'border: 1px solid #ee0000;'));

                $event->setSpec(
                    array(
                        'value' => '{$_nodeValue} VALUE',
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
            function (DrawFormEvent $event) {

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
            function (AjaxEvent $event) use ($request) {

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

    /**
     * Heavy testing action
     *
     * @return string
     */
    public function heavyAction()
    {
        $draw = $this->getServiceLocator()->get('WebinoDraw');

        $draw->setInstructions(
            array(
                'long-list' => array(
                    'locator' => '.long-list',
                    'cache' => 'long-list',
                    'instructions' => array(
                        'item' => array(
                            'locator' => 'li',
                            'value' => '{$_index} {$text}',
                            'loop' => array(
                                'base' => 'long_list',
                            ),
                        ),
                    ),
                ),
            )
        );

        // generate data
        $data = array();

        $text = 'Paš glouskůřenchlym niděk člobleď. Frc hrýš, tišlý pa chénizli tiškeš v fla děďmo '
                . 'choněr nivrýtlutat flyhlaž z mláď, vlireměh lkusteněm niništ a dibu i tes břetěm '
                . 'tiz škázly, di vu pypřouflel lápi hrgý kůn mymrůs niti k cháčnýzdleni a děslům. '
                . 'Glo tkesliti. Z těk těsak třizra člihreskni? Ni mevoď deš dihly dir slamrá gluni, '
                . 'zlýmlýjžré zluza uhřižlyj žletiv z tiďa v běchrou, mloj puzku ufluptoz nimi '
                . 'mipochroň slamu těbu, sech umepr o úbyl šlouží di tě mloumani. Bedic tymo s dini '
                . 'šrur. Dipěv i diď. Mleva a ti, gloněť stůjni glysk nyplýklech jetrou nizkuj '
                . 'a žragre. I ňorá tra dře paštaběn clys sini? Zoř žlůšké i bří šlicku, pyh úně '
                . 'glíhá a těvo kapeti.';

        $data['long_list'] = array();

        for ($i=0; $i < 500; $i++) {
            $data['long_list'][] = array('text' => $text);
        }

        return $data;
    }
}
