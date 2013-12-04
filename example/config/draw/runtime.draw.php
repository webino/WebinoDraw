<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

return array(
    'runtime-example-prepare' => array(
        'locator' => '.jumbotron',
        'html' => '{$_innerHtml}<div class="runtime-example">RUNTIME EXAMPLE</div>',
    ),
    /**
     * Options for this node are set
     * from action controller
     *
     * Check out test action controller.
     */
    'runtime-example' => array(
        'locator' => '.runtime-example',
        'helper' => 'WebinoDrawElement',
    ),
);
