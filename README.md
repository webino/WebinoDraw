# XHTML Layout Renderer <br /> for Zend Framework 2

[![Build Status](https://secure.travis-ci.org/webino/WebinoDraw.png?branch=develop)](http://travis-ci.org/webino/WebinoDraw "Develop Build Status")
[![Coverage Status](https://coveralls.io/repos/webino/WebinoDraw/badge.png?branch=develop)](https://coveralls.io/r/webino/WebinoDraw?branch=develop "Develop Coverage Status")
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/webino/WebinoDraw/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/webino/WebinoDraw/?branch=develop "Develop Quality Score")
[![Dependency Status](https://www.versioneye.com/user/projects/529f8de6632bac79c600003d/badge.svg)](https://www.versioneye.com/user/projects/529f8de6632bac79c600003d "Develop Dependency Status")
<br />
[![Latest Stable Version](https://poser.pugx.org/webino/webino-debug/v/stable.svg)](https://packagist.org/packages/webino/webino-debug) [![Total Downloads](https://poser.pugx.org/webino/webino-debug/downloads.svg)](https://packagist.org/packages/webino/webino-debug) [![Latest Unstable Version](https://poser.pugx.org/webino/webino-debug/v/unstable.svg)](https://packagist.org/packages/webino/webino-debug) [![License](https://poser.pugx.org/webino/webino-debug/license.svg)](https://packagist.org/packages/webino/webino-debug)

Provides ability to configure rendering of the layout. **Still under development, use it for play.**

- Demo [webino-draw.demo.webino.org](http://webino-draw.demo.webino.org)

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

        'webino_draw' => [
            'instructions' => [
                // Add draw instructions here
                'draw-node-example' => [
                    'locator' => 'body',
                    'value'   => 'Hello Webino!',
                ],
            ],
        ],

    Reload your browser and you should see "Hello Webino!" as a body content.

  - Rendering is based on instructions mapped to DOM nodes like this:

        'draw-node-example' => [              // custom name
            'locator' => 'body',              // node locator
            'helper'  => 'WebinoDrawElement', // draw helper
            'value'   => 'Hello Webino!',     // helper options
        ],

  - You can use **CSS selector** or **XPath** even combine them together to map dom nodes to draw instruction.

    It is possible to set many CSS or/and XPath locators:

        'draw-node-example' => [
            'locator' => [
                'body a',
                '.customclass',
                'xpath=//title',
                'xpath=//footer',
            ],
            'value' => 'Hello Webino!',
        ],

  - To specify priority of each instruction use **stackIndex** option:

        'draw-node-example' => [
            'stackIndex' => 9,
            'locator'    => 'body',
            'value'      => 'Hello Webino!',
        ],

  - In the instructions hierarchy you can use relative locators:

        'quick-contact' => [
            'locator' => '.quick-contact',         // the same node
            'instructions' => [
                'widget' => [
                    'locator' => '.',              // the same node
                    'locator' => 'xpath=.',        // the same node
                    // ...
                ],
            ],
        ],

    *NOTE: Every sub-locator css selector will be resolved as relative. If you want to match by absolute css selector, start with double slash, e.g. `//.quick-contact`.*

  - Use **node variables**:

        'draw-node-example' => [
            'locator' => 'a',
            'value'   => 'customprefix {$_nodeName} {$_nodeValue} {$_nodePath} customsuffix',
            'html'    => '<custom>{$_innerHtml}</custom>',
            'replace' => '{$_outerHtml}<custom/>',
            'attribs' => [
                'title' => '{$_nodeValue} {$_href}',
                'href'  => '{$_href}#customfragment',
            ],
        ],

    *NOTE: Node variables are prefixed with the underscore to avoid conflicts.*

  - Use **view variables**:

    Assume that controller action return view model with multidimensional array.

        'draw-node-example' => [
            'locator' => 'body',
            'value'   => '{$viewvar}',
        ],

    Set and override:

        'draw-node-example' => [
            'locator' => 'body',
            'value'   => '{$viewvar}',
            'var' => [
                'set' => [
                    'viewvar' => 'customval',
                ],
             ],
        ],

    Fetch variables:

        'draw-node-example' => [
            'locator' => 'body',
            'value'   => '{$depthvar}',
            'var' => [
                'fetch' => [
                    'depthvar' => 'value.in.the.depth',
                ],
            ],
        ],


    Set default variables:

        'draw-node-example' => [
            'locator' => 'body',
            'value'   => '{$viewvar}',
            'var' => [
                'default' => [
                    'viewvar' => 'defaultval',
                ],
             ],
        ],

    Push variables:

        'draw-node-example' => [
            'locator' => 'body',
            'var' => [
                'push' => [
                    'myvalue.in.the.depth' => 'mydepthvar',
                ],
            ],
        ],

  - Use **functions**, **view helpers** and **filters**:

    Modify variable values, helper/filter definition accepts in function/method parameters: `{$var}`

        'draw-node-example' => [
            'locator' => 'body',
            'value'   => '{$customvar}',
            'var' => [
                'helper' => [
                    'customvar' => [
                        'customhelper' => [
                            '__invoke' => [[]],
                        ],
                        'customfunction' => [[]],
                    ],
                ],
                'filter' => [
                    'pre' => [
                        'customvar' => [
                            'customfilter'   => [],
                            'customfunction' => [],
                        ],
                    ],
                    'post' => [],
                ],
            ],
        ],

  - **Loop** by view array:

        'draw-node-example' => [
            'locator' => 'ul li',
            'value'   => '{$_key} {$_index} {$property}',
            'loop' => [
                'base'    => 'array.in.the.depth',
                'index'   => '0',
                'onEmpty' => [
                    'locator' => 'ul',
                    'replace' => '<p>You have no items.</p>',
                ],
            ],
        ],

    *NOTE: Extra variables are prefixed with the underscore to avoid conflicts.*

  - Trigger **events**

        'event-example' => [
            'locator' => 'body',
            'trigger' => [
                'event-example.test',
            ],
        ],

    Then attach listener:

        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            'event-example.test',
            function(DrawEvent $event) {

                // set custom variables
                $event->getHelper()->setVars([]);

                // do something with the nodes
                $event->getNodes()->setValue("my node value");

                // change instruction node
                $event->setSpec([
                    // draw instructions
                    'value' => '{$_nodeValue} VALUE',
                    'attribs' => [
                        'title' => 'Hello from Controller!',
                    ],
                ]);
            }
        );

  - Set instructions **from controller**:

        $this->getServiceLocator()->get('WebinoDraw')->setInstructions([
            'custom' => [
                'locator' => '.customclass',
                'value'   => 'Custom value',
            ],
        ]);

    Set instructions always merge so in some cases it is useful to clear them:

        $this->getServiceLocator()->get('WebinoDraw')->clearInstructions();

  - **Cache**

        'cache-example' => [
            'locator'   => 'body',
            'cache'     => 'exampleCacheTag',
            'cache_key' => ['{$var}'],
            'cache_key_trigger' => [
                'draw.cache.byPage',
            ],
        ],

    Attach cache key listener:

        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            'draw.cache.byPage',
            function(Event $event) use ($navigation) {

                $page = $navigation->getActivePage();
                return $page->getHref();
            }
        );

    Clear the cache:

        $this->getServiceLocator()->get('WebinoDrawCache')->clearByTags(['exampleCacheTag']);

    *NOTE: When cached data are loaded, the draw helper manipulation is skipped, nor AjaxEvent is fired.*

## Instruction Set

  - The instruction set allows you to configure group of draw instructions under custom name:

        'webino_draw' => [
            'instructionset' => [
                'customname' => [
                    // Add draw instructions here
                ],
            ],
        ],

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
            $(document).on("click", ".ajax-link", function(event) {
                event.preventDefault();
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
            $event->setJson(['extraExample' => 'my extra ajax']);

            // change XPath of fragments to render
            $event->setFragmentXpath('//*[contains(@class, "my-ajax-fragment"])');
        }
    );

  *NOTE: AjaxEvent will not be triggered if you use JsonModel as a MvcEvent response.*

### Ajax Settings

  There are default settings to configure the Ajax support:

    'webino_draw' => [
        // container is the area to render (in the layout)
        'ajax_container_xpath' => '//body',

        // fragment is the part of the container to receive
        'ajax_fragment_xpath' => '//*[contains(@class, "ajax-fragment") and @id]',
    ],

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

    'draw-element-example' => [
        'locator' => '.customclass',
        'helper'  => 'WebinoDrawElement',                // default (not required to set)

        // Helper options:
        'value' => 'Draw element example value',         // set node value
        'render' => [
            'script' => 'script/path'                    // render view script to variable
        ],
        'fragments' => [                                 // HTML fragments of the template to variables
            'frag' => '.frag-class'                      // pairs of customName => locator, gives us fragOuterHtml and fragInnerHtml variables
        ],
        'html' => '<span>HTML value</span>{$script}',    // set node XHTML
        'attribs' => [                                   // set attributes
            'title' => 'Attribute example'
        ],
        'remove'  => '.',                                // locator|array, removes target node
        'replace' => '<strong/>',                        // XHTML, replaces node
        'onEmpty' => [                                   // custom options if node is empty
            'value' => 'Empty node example',             // use same options as normal
        ],
        'var' => [
            'set' => [                                   // set variables values
                'myvar' => 'myval',                      // key => value pairs
            ],
            'fetch' => [                                 // fetch variables from multidimensional array
                'myvar' => 'base.path',                  // local variable name => variable base path pairs
            ],
            'default' => [                               // set default variables values
                'myvar' => 'mydefaultval',               // key => default value pairs
            ],
            'push' => [                                  // push variables values to the global context
                'my.base.path' => 'myval',               // custom variable base path => value pairs
            ],
            'helper' => [                                // use helpers on variables
                'customvar' => [
                    '_join_result' => false,             // bool, disable the string result joining, default true
                    'customhelper' => [                  // zend helper
                        '__invoke' => [[]],              // zend helper methods with params
                    ],
                    'customfunction' => [[]],            // use php function with params
                ],
            ],
            'filter' => [                                // filter variables
                'pre' => [                               // filter called before helpers
                    'customvar' => [
                        'customfilter'   => [],          // use zend filter with params
                        'customfunction' => [],          // use php function with params
                    ],
                ],
                'post' => [
                                                         // filter called after helper, same as for pre
                ],
            ],
        ],
        'onVar' => [                                     // variables logic
            'customIndex => [                            // options per variable
                'var'        => '{$customvar}',          // test variable value
                'equalTo'    => '',                      // condition method (or)
                'notEqualTo' => '',                      // condition method
                'instructionset' => [                    // sub-instructionset to expand instructions

                ],
                'instructions' => [                      // sub-instructions processed when condition is true

                ],
            ],
        ],
        'instructionset' => [                            // instructionset to expand instructions

        ],
        'instructions' => [                              // sub-instructions to draw over nodes
                                                         // add different helper instructions
        ],
        'trigger' => [
            'event-example.test',                        // event name per item, identificator = WebinoDraw
        ],
        'loop' => [                                      // loop node by view array items
            'base'    => 'depth.items',                  // path to view array
            'index'   => '0',                            // index start point (optional)
            'offset'  => '0',                            // items offset (optional)
            'length'  => '0',                            // items length (optional)
            'shuffle' => false,                          // shuffle items
            'helper' => function(                        // LoopHelper|callable, called on each item (optional)
                $loopArgument, array $options
            ){},
            'onEmpty'  => [                              // custom options if items array is empty
                                                         // use same options as normal
            ],
            'instructionset' => [                        // instructionset to expand instructions

            ],
            'instructions' => [                          // instructions to draw looped element nodes
                                                         // add same instructions as normal
            ],
        ],
        'cache' => '',                                   // string|array cache tags
    ],

### WebinoDrawForm

  Use it to render the form. If `<form/>` template is empty use the default render else try to match
  form elements by name attribute.

    'draw-form-example' => [
        'localtor' => 'form.form-example',
        'helper'   => 'WebinoDrawForm',

        // Helper options:
        'form'        => 'exampleForm',             // form available via ServiceManager
        'route'       => 'example_route',           // available route
        'populate'    => '{$values}',               // populate form values
        'text_domain' => __NAMESPACE__,             // form translator text domain
        'instructionset' => [                       // instructionset to expand instructions

        ],
        'instructions' => [                         // sub-instructions to decorate the form
                                                    // add different helper instructions
        ],
        'trigger' => [                              // trigger event passes form to the event parameters
            'form-example.event',                   // event name per item, identificator = WebinoDraw
        ],
        'cache' => '',                              // string|array cache tags
    ],

  Assume form template:

    <form class="form-example">
        <input name="example_text_element"/>        <!-- form elements are mapped by name attribute -->
        <input name="send"/>
    </form>

  If you do not have any form you can create one easily:

    'forms' => [
        'exampleForm' => [
            'hydrator' => \Zend\Stdlib\Hydrator\ArraySerializable::class,
            'attributes' => [
                'method' => 'post',
                'class'  => 'example-form',
            ],
            'elements' => [
                'example_text_element' => [
                    'spec' => [
                        'name' => 'example_text_element',
                        'options' => [
                            'label' => 'Label example',
                        ],
                        'attributes' => [
                            'type'        => 'text',
                            'placeholder' => 'Type something ...',
                        ],
                    ],
                ],
            ],
            'input_filter' => [
                'example_text_element' => [
                    'name'     => 'example_text_element',
                    'required' => true,
                    'validators' => [

                    ],
                ],
            ],
        ],
    ],

### WebinoDrawAbsolutize

  Absolutize the relative URLs (default attributes: src, href, action).

    'absolutize' => [
        'stackIndex' => 9999998,
        'helper'     => 'WebinoDrawAbsolutize',
        'locator'    => (new \WebinoDraw\Draw\Helper\Absolutize\AbsolutizeLocator)->getLocator(),
    ],

  Extend locator with the *my-attr* attribute:

    'absolutize' => [
        'locator' => [
            'my-attr' => 'xpath=//@my-attr' . (new \WebinoDraw\Draw\Helper\Absolutize\AbsolutizeLocator)->getCondition(),
        ],
    ],

  *NOTE: Now you do not have to prepend URLs with a `$this->view->basePath()`.*

## Pitfalls

  - In case of troubles use `<![CDATA[ ]]>` with entities, like `&amp;` to: `<![CDATA[&amp;]]>`

  - You may experience result in garbage (encoded) text, replace the meta charset in the layout with following:

        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>

  - To draw the form collection the WebinoDraw FormElement and FormRow view helper is used. It solves
    some issues with the translator when the Zend FormElement view helper is used, because it does not allow to pass
    translator text domain to its elements.

  - To specify the view helper to render the form element set its `view_helper` option.

  - When you don't want to absolutize the element attribute add `data-webino-draw-absolutize="no"` to it's attributes.

  - When using helpers with view helpers multiple methods call on the same variable, the string result is automatically
    joined. Use `_join_result = false` option to disable this behaviour.

## Examples

  Look for more examples in: `examples/config/module.config.php`

### Manual setup

  1. Install ZendSkeletonApplication

  2. Set up WebinoDraw module

  3. Set up module test configuration:
    - Copy: `vendor/webino/webino-draw/test/resources/application.config.php`
    - Paste it to application: `config/application.config.php` (replace)

  4. Check your application welcome page for changes

[Check out wiki for more examples](https://github.com/webino/WebinoDraw/wiki)

## Development

We will appreciate any contributions on development of this module.

Learn [How to develop Webino modules](https://github.com/webino/Webino/wiki/How-to-develop-Webino-module)

## Todo

  - DrawHelper how to
  - Add DrawResized to resize images
  - Write tests for draw form and new features (events + sub-instructions + ajax + cache)
  - Write tests + manual for DrawPagination
  - Write tests + manual for DrawTranslate
  - Write tests + examples for DrawElement {$_outerHtml}
  - Write tests for DrawAjaxHtmlStrategy
  - Write doc about var fetch _first and _last magic keys
  - Write test for onVar support
  - Write tests for spec instructionset to expand instructions
  - Disable the var helpers multiple methods call on the same variable auto join the result, BC break
  - Redesign var helpers and filters API, cos helper/filter name as a key causes issues when we wan to override via config merge, BC break
  - Write loop helper manual + tests
  - Upgrade Zend MVC
  - Upgrade Zend Form

## Addendum

  Please, if you are interested in this Zend Framework module report any issues and don't hesitate to contribute.

[Report a bug](https://github.com/webino/WebinoDraw/issues) | [Fork me](https://github.com/webino/WebinoDraw)
