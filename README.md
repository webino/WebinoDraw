# XHTML Layout Renderer for Zend Framework

  [![Build Status](https://secure.travis-ci.org/webino/WebinoDraw.png?branch=master)](http://travis-ci.org/webino/WebinoDraw "Master")
  [![Build Status](https://secure.travis-ci.org/webino/WebinoDraw.png?branch=develop)](http://travis-ci.org/webino/WebinoDraw "Develop")

  Provides ability to configure rendering of the layout. Still under development.

  ![WebinoDraw principle](http://static.webino.org/documentation/webino_draw_principle.png)

## Features

  - Configurable layout.
  - Decoupled logic from template.
  - Uses ZF2 view variables and helpers.
  - Works with pure XHTML5.
  - You can still use phtml, but why!

## Setup

  Following steps are necessary to get this module working (considering a zf2-skeleton or very similar application).

  1. Run: `php composer.phar require webino/webino-draw:dev-develop`
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

    Assume that controller action return view model with multi-dimensional array.

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

  - Use **functions** and **view helpers**:

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
        'onEmpty' => array(

            // Custom options if node is empty:
            'value' => 'Empty node example',             // use same options
        ),
    ),

## Pitfalls

  - Use `<![CDATA[ ]]>` with entities, like `&amp;` to: `<![CDATA[&amp;]]>`

## Examples

  Look for more examples in: `config/webinodrawexample.local.php.dist`

  - Install ZendSkeletonApplication.
  - Setup WebinoDraw module.
  - Copy: `vendor/webino/webino-draw/config/webinodrawexample.local.php.dist`
  - Paste it to application: `config/autoload/webinodrawexample.local.php`
  - Check your ZF2 Application welcome page for changes.

## Todo

  - The "remove": Add multiple xpath or query option.
  - Variable case support.
  - Draw helper trigger event.
  - Draw loop.
  - Ajax.
  - Cache.

## Addendum

  Please, if you are interested in this Zend Framework module report any issues and don't hesitate to contribute.

  [Report a bug](https://github.com/webino/WebinoDraw/issues) | [Fork me](https://github.com/webino/WebinoDraw)

