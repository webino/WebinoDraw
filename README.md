# XHTML Layout Renderer for Zend Framework

  [![Build Status](https://secure.travis-ci.org/webino/WebinoDraw.png?branch=master)](http://travis-ci.org/webino/WebinoDraw "Master")
  [![Build Status](https://secure.travis-ci.org/webino/WebinoDraw.png?branch=develop)](http://travis-ci.org/webino/WebinoDraw "Develop")

  Provides ability to configure rendering of the layout. **Still under development, use it for play.**

  <br />

  ![WebinoDraw principle](http://static.webino.org/documentation/webino_draw_principle.png)

## Features

  - Auto escape
  - [Ajax support](#ajax)
  - Configurable layout
  - Decoupled logic from template
  - Works with pure XHTML5 (no extra markup required)
  - Trigger events
  - [Draw forms](#webinodrawform) (collection or map to HTML)
  - [Absolutize](#webinodrawabsolutize) the URLs
  - Cache
  - Uses PHP functions, ZF2 view variables, helpers and filters
  - You can still use phtml, but why!

## Why?

  - Templates without logical markup mess
  - Pretty fast with cache enabled
  - Override configuration settings to change logical behavior of templates for modular projects

## Setup

  Following steps are necessary to get this module working, considering a zf2-skeleton or very similar application:

  1. Add `"minimum-stability": "dev"` to your composer.json, because this module is under development

  2. Run `php composer.phar require webino/webino-draw:dev-develop`

  3. Add `WebinoDraw` to the enabled modules list

## Requirements

  - XHTML(5) doctype

## QuickStart

  - For example, add this code somewhere to your module config:

        'webino_draw' => array(
            'instructions' => array(

                // Add draw instructions here
                'draw-node-example' => array(
                    'locator' => 'body',
                    'value'   => 'Hello Webino!',
                ),
            ),
        ),

    Reload your browser and you should see "Hello Webino!" as a body content.

  - Rendering is based on instructions mapped to DOM nodes like this:

        'draw-node-example' => array(         // custom name
            'locator' => 'body',              // node locator
            'helper'  => 'WebinoDrawElement', // draw helper
            'value'   => 'Hello Webino!',     // helper options
        ),

  - You can use **CSS selector** or **XPath** even combine them together to map dom nodes to draw instruction.

    It is possible to set many CSS or/and XPath locators:

        'draw-node-example' => array(
            'locator' => array(
                'body a',
                '.customclass',
                'xpath=//title',
                'xpath=//footer',
            ),
            'value'  => 'Hello Webino!',
        ),

  - To specify priority of each instruction use **stackIndex** option:

        'draw-node-example' => array(
            'stackIndex' => '9',
            'locator'    => 'body',
            'value'      => 'Hello Webino!',
        ),

  - Use **node variables**:

        'draw-node-example' => array(
            'locator' => 'a',
            'value'   => 'customprefix {$_nodeValue} customsuffix',
            'html'    => '<custom>{$_innerHtml}</custom>',
            'replace' => '{$_outerHtml}<custom/>',
            'attribs' => array(
                'title' => '{$_nodeValue} {$_href}',
                'href'  => '{$_href}#customfragment',
             ),
        ),

    *NOTE: Node variables are prefixed with the underscore to avoid conflicts.*

  - Use **view variables**:

    Assume that controller action return view model with multidimensional array.

        'draw-node-example' => array(
            'locator' => 'body',
            'value'   => '{$viewvar}',
        ),

    Set and override:

        'draw-node-example' => array(
            'locator' => 'body',
            'value'   => '{$viewvar}',
            'var'     => array(
                'set' => array(
                    'viewvar' => 'customval',
                ),
             ),
        ),

    Fetch variables:

        'draw-node-example' => array(
            'locator' => 'body',
            'value'   => '{$depthvar}',
            'var'     => array(
                'fetch' => array(
                    'depthvar' => 'value.in.the.depth',
                ),
            ),
        ),


    Set default variables:

        'draw-node-example' => array(
            'locator' => 'body',
            'value'   => '{$viewvar}',
            'var'     => array(
                'default' => array(
                    'viewvar' => 'defaultval',
                ),
             ),
        ),

  - Use **functions**, **view helpers** and **filters**:

    Modify variable values, helper/filter definition accepts in function/method parameters: `{$var}`

        'draw-node-example' => array(
            'locator' => 'body',
            'value'   => '{$customvar}',
            'var'     => array(
                'helper' => array(
                    'customvar' => array(
                        'customhelper' => array(
                            '__invoke' => array(array()),
                        ),
                        'customfunction' => array(array()),
                    ),
                ),
                'filter' => array(
                    'pre' => array(
                        'customvar' => array(
                            'customfilter'   => array(),
                            'customfunction' => array(),
                        ),
                    ),
                    'post' => array(),
                ),
            ),
        ),

  - **Loop** by view array:

        'draw-node-example' => array(
            'locator' => 'ul li',
            'value'   => '{$_key} {$_index} {$property}',
            'loop'    => array(
                'base'    => 'array.in.the.depth',
                'index'   => '0',
                'onEmpty' => array(
                    'locator' => 'ul',
                    'replace' => '<p>You have no items.</p>',
                ),
            ),
            'attribs' => array(
                'title' => '{$property}',
            ),
        ),

    *NOTE: Extra variables are prefixed with the underscore to avoid conflicts.*

  - Trigger **events**

        'event-example' => array(
            'locator' => 'body',
            'trigger' => array(
                'event-example.test',
            ),
        ),

    Then attach listener:

        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            'event-example.test',
            function(DrawEvent $event) {

                // set custom variables
                $event->getHelper()->setVars(array());

                // do something with the nodes
                $event->getNodes()->setValue("my node value");

                // change instruction node
                $event->setSpec(
                    array(
                        // draw instructions
                        'value'   => '{$_nodeValue} VALUE',
                        'attribs' => array(
                            'title' => 'Hello from Controller!',
                        ),
                    )
                );
            }
        );

  - Set instructions **from controller**:

        $this->getServiceLocator()->get('WebinoDraw')->setInstructions(array(
            'custom' => array(
                'locator' => '.customclass',
                'value'   => 'Custom value',
            ),
        ));

    Set instructions always merge so in some cases it is useful to clear them:

        $this->getServiceLocator()->get('WebinoDraw')->clearInstructions();

  - **Cache**

        'cache-example' => array(
            'locator' => 'body',
            'cache'   => 'exampleCacheTag',
        ),

    Clear the cache:

        $this->getServiceLocator()->get('WebinoDrawCache')->clearByTags(array('exampleCacheTag'));

    *NOTE: When cached data are loaded, the draw helper manipulation is skipped, nor AjaxEvent is fired.*

## Instruction Set

  - The instruction set allows you to configure group of draw instructions under custom name:

        'webino_draw' => array(
            'instructionset' => array(
                'customname' => array(
                    // Add draw instructions here
                ),
            ),
        ),

  - Later you can get those instructions and set them to the WebinoDraw service:

        $draw = $this->getServiceLocator()->get('WebinoDraw');
        $draw->setInstructions(
            $draw->instructionsFromSet('customname')
        );

## Ajax

  WebinoDraw supports Ajax, that means you can request any fragments of the layout body from the web server
  and update the elements via Javascript in the DOM of the web page.

  Assume Ajax as a process of sending / receiving data to the server on the web page background.
  The JSON format is used for that purpose.

  1. Set up the Ajax handler. Use the following jQuery script:

        jQuery(document).ready(function($){

            $(document).on("click", ".ajax-link", function() {

                $.get($(this).attr("href"), function(data) {

                    // replace element HTML with each received fragment
                    $.each(data.fragment, function(selector, html) {
                        $(selector).replaceWith(html);
                    });

                    // custom data whatever
                    if (data.extraExample) {
                        $(".my-ajax-data").html(data.extraExample);
                    }

                }, "json");

                return false;
            });
        });

    *NOTE: Above script makes every element with a class name "ajax-link" Ajax-able.
           It is required that element has the "href" attribute.*

    *NOTE: The JSON `data.fragment` contains the `selector => XHTML` pairs.*

    *NOTE: We can receive custom parameters and do whatever we want with them.*

  2. Add an id and the class name "ajax-fragment" to the every element you want to change via Ajax.

     Assume following element somewhere in the layout body tag:

        <div id="my-ajax-area" class="ajax-fragment">Ajax-able content</div>

  3. Now when you click Ajax-able element, every Ajax-able fragment will be updated.

### AjaxEvent

  The Ajax request triggers the Ajax event, then you can add custom JSON data and change the XPath of fragments to render.

        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            AjaxEvent::EVENT_AJAX,
            function(AjaxEvent $event) {

                // add custom JSON data
                $event->setJson(array('extraExample' => 'my extra ajax'));

                // change XPath of fragments to render
                $event->setFragmentXpath('//*[contains(@class, "my-ajax-fragment"])');
            }
        );

  *NOTE: AjaxEvent will not be triggered if you use JsonModel as a MvcEvent response.*

### Ajax Settings

  There are default settings to configure the Ajax support:

        'webino_draw' => array(

            // container is the area to render (in the layout)
            'ajax_container_xpath' => '//body',

            // fragment is the part of the container to receive
            'ajax_fragment_xpath' => '//*[contains(@class, "ajax-fragment") and @id]',
        ),

  *NOTE: Only elements matched with container XPath will be rendered.*

  Override those settings to be more specific to the layout, if you want.

  The layout may contain many Ajax containers with many fragments.
  It's up to you how you match them with the XPath via Ajax settings.
  Maybe you want to render only the nav and the content e.g. `'ajax_container_xpath' => '//nav|//content'`
  then also receive them as fragments `'ajax_fragment_xpath' => '//nav|//content'`. So only the required parts
  will be rendered and received, thus saving resources by skipping rendering of the header, footer and the other waste
  surrounding the ajax containers in the layout body.

## Helpers

  Modularity of the draw is provided by custom classes which consumes DOM nodes, options and data
  to make operations over DOM nodes.

### WebinoDrawElement

  Use it to modify the element of the page. Many options, very powerful.

    'draw-element-example' => array(
        'locator' => '.customclass',
        'helper'  => 'WebinoDrawElement',                // default (not required to set)

        // Helper options:
        'value'   => 'Draw element example value',       // set node value
        'render'  => array(
            'script' => 'script/path'                    // render view script to variable
        ),
        'html'    => '<span>HTML value</span>{$script}', // set node XHTML
        'attribs' => array(                              // set attributes
            'title' => 'Attribute example'
        ),
        'remove'  => 'xpath=.',                          // locator|array, removes target node
        'replace' => '<strong/>',                        // XHTML, replaces node
        'onEmpty' => array(                              // custom options if node is empty
            'value' => 'Empty node example',             // use same options as normal
        ),
        'var' => array(
            'helper' => array(                           // use helpers on variables
                'customvar' => array(
                    'customhelper' => array(             // zend helper
                        '__invoke' => array(array()),    // zend helper methods with params
                    ),
                    'customfunction' => array(array()),  // use php function with params
                ),
            ),
            'filter' => array(                           // filter variables
                'pre' => array(                          // filter called before helpers
                    'customvar' => array(
                        'customfilter'   => array(),     // use zend filter with params
                        'customfunction' => array(),     // use php function with params
                    ),
                ),
                'post' => array(
                                                         // filter called after helper, same as for pre
                ),
            ),
        ),
        'instructions' => array(                         // sub-instructions to draw over nodes
                                                         // add different helper instructions
        ),
        'trigger' => array(
            'event-example.test',                        // event name per item, identificator = WebinoDraw
        ),
        'loop' => array(                                 // loop node by view array items
            'base'     => 'depth.items',                 // path to view array
            'index'    => '0',                           // index start point (optional)
            'offset'   => '0',                           // items offset (optional)
            'length'   => '0',                           // items length (optional)
            'callback' => function($item, $helper){},    // called on each item (optional)
            'onEmpty'  => array(                         // custom options if items array is empty
                                                         // use same options as normal
            ),
            'instructions' => array(                     // instructions to draw looped element nodes
                                                         // add same instructions as normal
            ),
        ),
        'cache' => '',                                   // string|array cache tags
    ),

### WebinoDrawForm

  Use it to render the form. If `<form/>` template is empty use the default render else try to match
  form elements by name attribute.

    'draw-form-example' => array(
        'localtor' => 'form.form-example',
        'helper'   => 'WebinoDrawForm',

        // Helper options:
        'form'         => 'exampleForm',            // form available via ServiceManager
        'route'        => 'example_route',          // available route
        'text_domain'  => __NAMESPACE__,            // form translator text domain
        'instructions' => array(                    // sub-instructions to decorate the form
                                                    // add different helper instructions
        ),
        'trigger' => array(                         // trigger event passes form to the event parameters
            'form-example.event',                   // event name per item, identificator = WebinoDraw
        ),
        'cache' => '',                              // string|array cache tags
    ),

  Assume form template:

    <form class="form-example">
        <input name="example_text_element"/>        <!-- form elements are mapped by name attribute -->
        <input name="send"/>
    </form>

  If you do not have any form you can create one easily:

    'di' => array(
        'instance' => array(
            'alias' => array(
                'exampleForm' => 'WebinoDraw\Form\DiForm',
            ),
            'exampleForm' => array(
                'parameters' => array(
                    'config' => array(
                        'hydrator' => 'Zend\Stdlib\Hydrator\ArraySerializable',
                        'attributes' => array(
                            'method' => 'post',
                            'class' => 'example-form',
                        ),
                        'elements' => array(
                            array(
                                'spec' => array(
                                    'name'    => 'example_text_element',
                                    'options' => array(
                                        'label' => 'Label example',
                                    ),
                                    'attributes' => array(
                                        'type'        => 'text',
                                        'placeholder' => 'Type something ...',
                                    ),
                                ),
                            ),
                        ),
                        'input_filter' => array(
                            'example_text_element' => array(
                                'name'       => 'example_text_element',
                                'required'   => true,
                                'validators' => array(

                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),


  *NOTE: DiForm form is just like an ordinary Zend Form, but it could be instantiated via DI.*

  *NOTE: If you don't want to use DiForm just inject one into ServiceManager.*

### WebinoDrawAbsolutize

  Absolutize the relative URLs (default attributes: src, href, action).

    'absolutize' => array(
        'stackIndex' => '9999998',
        'helper' => 'WebinoDrawAbsolutize',
        'locator' => \WebinoDraw\View\Helper\DrawAbsolutize::getDefaultLocator(),
    ),

  Extend locator with the *my-attr* attribute:

    'absolutize' => array(
        'locator' => array(
            'my-attr' => 'xpath=//@my-attr' . \WebinoDraw\View\Helper\DrawAbsolutize::LOCATOR_CONDITION,
        ),
    ),

  *NOTE: Now you do not have to prepend URLs with a `$this->view->basePath()`.*

## Pitfalls

  - In case of troubles use `<![CDATA[ ]]>` with entities, like `&amp;` to: `<![CDATA[&amp;]]>`

  - You may experience result in garbage (encoded) text, replace the meta charset in the layout with following:

        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>

  - To create the form the DiForm is used. It allows to instantiate the object of type FormInterface
    via DI directly. However any valid form available via ServiceManager can be used.

  - To draw the form collection the WebinoDraw FormElement and FormRow view helper is used. It solves
    some issues with the translator when the Zend FormElement view helper is used, because it does not allow to pass
    translator text domain to its elements.

  - To specify the view helper to render the form element set its view_helper option.

  - When you don't want to absolutize the element attribute add `data-webino-draw-absolutize="no"` to it's attributes.

## Examples

  Look for more examples in: `config/webinodrawexample.local.php.dist`

**Manual setup**

  1. Install ZendSkeletonApplication

  2. Set up WebinoDraw module

  3. Set up module test configuration:
    - Copy: `vendor/webino/webino-draw/test/resources/config.local.php`
    - Paste it to application: `config/autoload/config.local.php` <br /><br />

  3. Set up module example configuration:
    - Copy: `vendor/webino/webino-draw/config/webinodrawexample.local.php.dist`
    - Paste it to application: `config/autoload/webinodrawexample.local.php` <br /><br />

  4. Set up module example controller:
    - Copy: `vendor/webino/webino-draw/test/resources/IndexController.php`
    - Paste it to application: `src/Application/Controller/IndexController.php` <br /><br />

  7. Check your ZF2 Application welcome page for changes

[Check out wiki for more examples](https://github.com/webino/WebinoDraw/wiki)

## Develop

**Requirements**

  - Linux (recommended)
  - NetBeans (optional)
  - Phing
  - PHPUnit
  - Selenium
  - Web browser

**Setup**

  1. Clone this repository and run: `phing update`

     Now your development environment is set.

  2. Open project in (NetBeans) IDE

  3. To check module integration with the skeleton application open following directory via web browser:

  `._test/ZendSkeletonApplication/public/`

     e.g. [http://localhost/WebinoDraw/._test/ZendSkeletonApplication/public/](http://localhost/WebinoDraw/._test/ZendSkeletonApplication/public/)

  4. Integration test resources are in directory: `test/resources`

     *NOTE: Module example config is also used for integration testing.*

**Testing**

  - Run `phpunit` in the test directory
  - Run `phing test` in the module directory to run the tests and code insights

    *NOTE: To run the code insights there are some tool requirements.*

## Todo

  - Variable switch/case support, maybe
  - DrawHelper how to
  - Add DrawResized to resize images
  - Add debug profiler
  - Write tests for draw form and new features (events + sub-instructions + ajax + cache)
  - Write tests + manual for DrawPagination
  - Write tests + manual for DrawTranslate
  - Write tests + examples for DrawElement {$_outerHtml}
  - Write tests for DrawAjaxHtmlStrategy
  - Write doc about var fetch _first and _last magic keys

## Addendum

  Please, if you are interested in this Zend Framework module report any issues and don't hesitate to contribute.

[Report a bug](https://github.com/webino/WebinoDraw/issues) | [Fork me](https://github.com/webino/WebinoDraw)
