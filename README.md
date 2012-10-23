# XHTML Layout Renderer for Zend Framework 

[![Build Status](https://secure.travis-ci.org/webino/WebinoDraw.png?branch=master)](http://travis-ci.org/webino/WebinoDraw "Master")
[![Build Status](https://secure.travis-ci.org/webino/WebinoDraw.png?branch=develop)](http://travis-ci.org/webino/WebinoDraw "Develop")

Provides ability to configure rendering of the layout. Still under development.

## Features

- Configurable layout
- Decoupled logic from template
- Uses ZF view variables and helpers
- Works with pure XHTML5

Operates over any template engine. This module is intended to be the last view strategy, and it is so powerful that your views can be pure XHTML5.

## Setup

Following steps are necessary to get this module working (considering a zf2-skeleton or very similar application)

  1. Run `composer require webino/webino-draw:dev-master`
  2. Add `WebinoDraw` to the enabled modules list

## QuickStart

  - For example, add this code somewhere to your module config:

        'di' => array(
            'instance' => array(
                'Webino\View\Strategy\DrawStrategy' => array(
                    'parameters' => array(
                        'instructions' => array(

                            // Add your WebinoDraw instructions here:
                            'webino' => array(
                                'query'  => 'body',
                                'helper' => 'WebinoDrawElement',
                                'value'  => 'Hello Webino!',
                            ),
                        ),
                    ),
                ),
            ),
        ),

  - Reload your browser and you should see "Hello Webino!" as body content.
  - Rendering is based on instructions mapped to DOM nodes like this:

        'webino' => array(                   // custom name
            'query'  => 'body',              // css selector
            'xpath'  => '//footer',          // DOM XPATH
            'helper' => 'WebinoDrawElement', // draw helper
            'value'  => 'Hello Webino!',     // helper options
        ),

  - As you see you can use **css selector** or **xpath** even combine them together to map dom nodes to draw instruction.
  - It is possible to set multiple selectors and xpaths.

        'webino' => array(                  
            'xpath' => array(
                '//title',
                '//footer',
            ),
            'query' => array(
                'body a',
                '.customclass',
            ),
            'helper' => 'WebinoDrawElement',  
            'value'  => 'Hello Webino!',
        ),

  - Use **node variables**:

        {$html} ... attribs

  - Use **view variables**:

        'webino' => array(
            'query'  => 'title',
            'xpath'  => '//footer',
            'helper' => 'WebinoDrawElement',
            'value'  => '{$viewvar}',
        ),

  - Use **view helpers**:



  - Set instructions **from controller**:

        $this->getServiceLocator()->get('WebinoDrawStrategy')->setInstructions(array(
            'custom' => array(
                'query'  => '.customclass',
                'helper' => 'WebinoDrawElement',
                'value'  => 'Custom value',
            ),
        ));

  - Set instructions always merge so in some cases it is useful to clear them:

        $this->getServiceLocator()->get('WebinoDrawStrategy')->clearInstructions();

## Helpers

Modularity of draw is provided by custom classes which consumes options and data to make operations over DOM nodes.

*Copy code, paste it to your module config, change ".customclass" and play.*

**WebinoDrawElement**

Use it to modify element of page.

    'draw-element-example' => array(
        'query'  => '.customclass',         
        'helper' => 'WebinoDrawElement',  

        // Custom options:
        'value'   => 'Draw element example value',       // set node value
        'render'  => array(
            'script' => 'script/path'                    // render view script to variable
        ),
        'html'    => '<span>HTML value</span>{$script}', // set node xhtml
        'attribs' => array(                              // set attributes
            'title' => 'Attribute example'
        ),
        'remove'  => '.',                                // XPATH, removes target node
        'replace' => '<strong/>',                        // XHTML, replaces node
        'onEmpty' => array(

            // Custom options if node is empty:
            'value' => 'Empty node example',             // use same options
        ),
    ),

**DrawLoop**

Use it to draw data structures.

## Pitfalls

  - Use `<![CDATA[ ]]>` with entities, like `&amp;` to `<![CDATA[&amp;]]>`

## Todo

  - The "remove": Add multiple xpath or query option.
  - Node value variable support.
  - Variable fetch.
  - Adding element before other.
  - Variable case support.
  - Cache.

## Outro

Please, if you are interested in this Zend Framework module report any issues and don't hesitate to contribute.

[Report a bug](https://github.com/webino/WebinoDraw/issues) | [Fork me](https://github.com/webino/WebinoDraw)

