# XHTML Layout Renderer for Zend Framework

  [![Build Status](https://secure.travis-ci.org/webino/WebinoDraw.png?branch=master)](http://travis-ci.org/webino/WebinoDraw "Master")
  [![Build Status](https://secure.travis-ci.org/webino/WebinoDraw.png?branch=develop)](http://travis-ci.org/webino/WebinoDraw "Develop")

  Provides ability to configure rendering of the layout. **Still under development, use it for play.**

  **Supports easy [form rendering](#drawForm) with translations.**

  <br />

  ![WebinoDraw principle](http://static.webino.org/documentation/webino_draw_principle.png)

## Features

  - Auto escape.
  - Configurable layout.
  - Decoupled logic from template.
  - Works with pure XHTML5.
  - Trigger events.
  - Draw forms, collection and map to HTML.
  - Uses PHP functions, ZF2 view variables, helpers and filters.
  - You can still use phtml, but why!

## Setup

  Following steps are necessary to get this module working, considering a zf2-skeleton or very similar application:

  1. Add `"minimum-stability": "dev"` to your composer.json, because this module is under development.

  2. Run `php composer.phar require webino/webino-draw:dev-develop`

  3. Add `WebinoDraw` to the enabled modules list.

## Requirements

  - XHTML(5) doctype.

## QuickStart

  - For example, add this code somewhere to your module config:

        'webino_draw' => array(
            'instructions' => array(

                // Add draw instructions here
                'draw-node-example' => array(
                    'query'  => 'body',
                    'helper' => 'drawElement',
                    'value'  => 'Hello Webino!',
                ),
            ),
        ),

    Reload your browser and you should see "Hello Webino!" as a body content.

  - Rendering is based on instructions mapped to DOM nodes like this:

        'draw-node-example' => array(        // custom name
            'query'  => 'body',              // css selector
            'xpath'  => '//footer',          // DOM XPath
            'helper' => 'drawElement',       // draw helper
            'value'  => 'Hello Webino!',     // helper options
        ),

  - As you see you can use **css selector** or **xpath** even combine them together to map dom nodes to draw instruction.

    It is possible to set many selectors and XPath:

        'draw-node-example' => array(
            'xpath' => array(
                '//title',
                '//footer',
            ),
            'query' => array(
                'body a',
                '.customclass',
            ),
            'helper' => 'drawElement',
            'value'  => 'Hello Webino!',
        ),

  - To specify priority of each instruction use **stackIndex** option:

        'draw-node-example' => array(
            'stackIndex' => '9',
            'query'      => 'body',
            'helper'     => 'drawElement',
            'value'      => 'Hello Webino!',
        ),

  - Use **node variables**:

        'draw-node-example' => array(
            'query'  => 'a',
            'helper' => 'drawElement',
            'value'  => 'customprefix {$nodeValue} customsuffix',
            'html'   => '<custom>{$html}</custom>',
            'attribs' => array(
                'title' => '{$nodeValue} {$href}',
                'href'  => '{$href}#customfragment',
             ),
        ),

  - Use **view variables**:

    Assume that controller action return view model with multidimensional array.

        'draw-node-example' => array(
            'query'  => 'body',
            'helper' => 'drawElement',
            'value'  => '{$viewvar}',
        ),

    Set and override:

        'draw-node-example' => array(
            'query'  => 'body',
            'helper' => 'drawElement',
            'value'  => '{$viewvar}',
            'var'    => array(
                'set' => array(
                    'viewvar' => 'customval',
                ),
             ),
        ),

    Fetch variables:

        'draw-node-example' => array(
            'query'  => 'body',
            'helper' => 'drawElement',
            'value'  => '{$depthvar}',
            'var'    => array(
                'fetch' => array(
                    'depthvar' => 'value.in.the.depth',
                ),
            ),
        ),


    Set default variables:

        'draw-node-example' => array(
            'query'  => 'body',
            'helper' => 'drawElement',
            'value'  => '{$viewvar}',
            'var'    => array(
                'default' => array(
                    'viewvar' => 'defaultval',
                ),
             ),
        ),

  - Use **functions**, **view helpers** and **filters**:

    Modify variable values, helper/filter definition accepts in function/method parameters: `{$var}`

        'draw-node-example' => array(
            'query'  => 'body',
            'helper' => 'drawElement',
            'value'  => '{$customvar}',
            'var'    => array(
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
            'query'  => 'ul li',
            'helper' => 'drawElement',
            'value'  => '{$key} {$index} {$property}',
            'loop'   => array(
                'base'    => 'array.in.the.depth',
                'index'   => '0',
                'onEmpty' => array(
                    'replace' => array(
                        '..' => '<p>You have no items.</p>',
                    ),
                ),
            ),
            'attribs' => array(
                'title' => '{$property}',
            ),
        ),

  - Trigger **events**

        'event-example' => array(
            'query'   => 'body',
            'helper'  => 'drawElement',
            'trigger' => array(
                'event-example.test',
            ),
        ),

    Then attach listener:

        $this->getEventManager()->getSharedManager()->attach(
            'WebinoDraw',
            'event-example.test',
            function($event) {
                $event->setSpec(
                    array(
                        // Draw instructions:
                        'value'   => '{$nodeValue} VALUE',
                        'attribs' => array(
                            'title' => 'Hello from Controller!',
                        ),
                    )
                );
            }
        );

        NOTE: Events are good for conditional data fetching, because when element is not available in the layout
        event is not fired thus skipping data load.

  - Set instructions **from controller**:

        $this->getServiceLocator()->get('ViewDrawStrategy')->setInstructions(array(
            'custom' => array(
                'query'  => '.customclass',
                'helper' => 'drawElement',
                'value'  => 'Custom value',
            ),
        ));

    Set instructions always merge so in some cases it is useful to clear them:

        $this->getServiceLocator()->get('ViewDrawStrategy')->clearInstructions();

## Instruction Set

  - The instruction set allows you to configure group of draw instructions under custom name:

        'webino_draw' => array(
            'instructionset' => array(
                'customname' => array(
                    // Add draw instructions here
                ),
            ),
        ),

  - Later you can get those instructions and set them to the draw strategy:

        $drawStrategy = $this->getServiceLocator()->get('ViewDrawStrategy');
        $drawStrategy->setInstructions(
            $drawStrategy->getInstructionsFromSet('customname')
        );

## Helpers

  Modularity of draw is provided by custom classes which consumes DOM nodes, options and data
  to make operations over DOM nodes.

### drawElement

  Use it to modify the element of the page.

    'draw-element-example' => array(
        'query'  => '.customclass',
        'helper' => 'drawElement',

        // Helper options:
        'value'   => 'Draw element example value',       // set node value
        'render'  => array(
            'script' => 'script/path'                    // render view script to variable
        ),
        'html'    => '<span>HTML value</span>{$script}', // set node XHTML
        'attribs' => array(                              // set attributes
            'title' => 'Attribute example'
        ),
        'remove'  => '.',                                // XPath, removes target node
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
            'base'    => 'depth.items',                  // path to view array
            'index'   => '0',                            // index start point (not required)
            'onEmpty' => array(                          // custom options if items array is empty
                                                         // use same options as normal
            ),
            'instructions' => array(                     // instructions to draw looped element nodes
                                                         // add same instructions as normal
            ),
        ),
    ),

### <a id="drawForm"></a>drawForm

  Use it to render the form. If `<form/>` template is empty use the default render else try to match
  form elements by name attribute.

    'draw-form-example' => array(
        'query'  => 'form.form-example',
        'helper' => 'drawForm',

        // Helper options:
        'form'  => 'exampleForm',                   // form available via ServiceManager
        'route' => 'example_route',                 // available route
        'text_domain' => __NAMESPACE__,             // form translator text domain
        'instructions' => array(                    // sub-instructions to decorate the form
                                                    // add different helper instructions
        ),
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
                'exampleForm' => 'WebinoDraw\Form\MagicForm',
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


    NOTE: Magic form is just like an ordinary zend form, but it could be instantiated via DI
    and fixes some issues with an element translation.

    NOTE: If you don't want to use Draw's MagicForm, just inject one into ServiceManager. But there can be potential
    problems with the translation. But watch translations!

## Pitfalls

  - Use `<![CDATA[ ]]>` with entities, like `&amp;` to: `<![CDATA[&amp;]]>`

  - To draw the form the Draw's MagicForm is used. It solves some temporary issues with translation when
    Zend's FormElement view helper is used, because it does not allow to pass translator text domain to its elements.
    Next issue it solves is feature, it allows to instantiate the object of type FormInterface via DI directly. However
    any valid form available via ServiceManager can be used.

## Examples

  Look for more examples in: `config/webinodrawexample.local.php.dist`

**Manual setup**

  1. Install ZendSkeletonApplication.

  2. Set up WebinoDraw module.

  3. Set up module test configuration:

    - Copy: `vendor/webino/webino-draw/test/resources/config.local.php`
    - Paste it to application: `config/autoload/config.local.php`


  3. Set up module example configuration:

    - Copy: `vendor/webino/webino-draw/config/webinodrawexample.local.php.dist`
    - Paste it to application: `config/autoload/webinodrawexample.local.php`


  4. Set up module example controller:

    - Copy: `vendor/webino/webino-draw/test/resources/IndexController.php`
    - Paste it to application: `src/Application/Controller/IndexController.php`


  7. Check your ZF2 Application welcome page for changes.

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

        NOTE: Module example config is also used for integration testing.

**Testing**

  - Run `phpunit` in test directory.
  - Run `phing test` in module directory to run test and code insights.

        NOTE: To run code insights there are some tools requirements.

## Todo

  - The "remove": Add multiple xpath or query option.
  - Variable switch/case support, maybe.
  - Ajax.
  - Cache.
  - DrawHelper how to.
  - Add DrawResized to resize images.
  - Add debug profiler.
  - Write tests for draw form and new features (events + sub-instructions).

## Addendum

  Please, if you are interested in this Zend Framework module report any issues and don't hesitate to contribute.

[Report a bug](https://github.com/webino/WebinoDraw/issues) | [Fork me](https://github.com/webino/WebinoDraw)

