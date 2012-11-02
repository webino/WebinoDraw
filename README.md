# XHTML Layout Renderer for Zend Framework

  [![Build Status](https://secure.travis-ci.org/webino/WebinoDraw.png?branch=master)](http://travis-ci.org/webino/WebinoDraw "Master")
  [![Build Status](https://secure.travis-ci.org/webino/WebinoDraw.png?branch=develop)](http://travis-ci.org/webino/WebinoDraw "Develop")

  Provides ability to configure rendering of the layout. **Still under development, use it for play.**

  ![WebinoDraw principle](http://static.webino.org/documentation/webino_draw_principle.png)

## Features

  - Configurable layout.
  - Decoupled logic from template.
  - Uses PHP functions, ZF2 view variables, helpers and filters.
  - Auto escape data.
  - Works with pure XHTML5.
  - You can still use phtml, but why!

## Setup

  Following steps are necessary to get this module working (considering a zf2-skeleton or very similar application).

  1. Run: `php composer.phar require webino/webino-draw:1.*`
  2. Add `WebinoDraw` to the enabled modules list.

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

    Reload your browser and you should see "Hello Webino!" as body content.

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

    Modify variable values, helper definition accepts in function/method parameters: `{$var}`

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

  - Loop by view array:

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

  *Copy code, paste it to your module config, change ".customclass" and play.*

**drawElement**

  Use it to modify element of page.

    'draw-element-example' => array(
        'query'  => '.customclass',
        'helper' => 'drawElement',

        // Custom options:
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

## Pitfalls

  - Use `<![CDATA[ ]]>` with entities, like `&amp;` to: `<![CDATA[&amp;]]>`

## Examples

  Look for more examples in: `config/webinodrawexample.local.php.dist`

  1. Install ZendSkeletonApplication.
  2. Set up WebinoDraw module.
  3. Copy: `vendor/webino/webino-draw/config/webinodrawexample.local.php.dist`
  4. Paste it to application: `config/autoload/webinodrawexample.local.php`
  5. Copy: `vendor/webino/webino-draw/test/resources/IndexController.php`
  6. Paste it to application: `src/Application/Controller/IndexController.php`
  7. Check your ZF2 Application welcome page for changes.

[Check out wiki for more examples](https://github.com/webino/WebinoDraw/wiki)

## Todo

  - The "remove": Add multiple xpath or query option.
  - Variable case support.
  - Instruction option to trigger event.
  - Ajax.
  - Cache.

## Addendum

  Please, if you are interested in this Zend Framework module report any issues and don't hesitate to contribute.

[Report a bug](https://github.com/webino/WebinoDraw/issues) | [Fork me](https://github.com/webino/WebinoDraw)

