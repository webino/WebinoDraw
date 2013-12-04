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
    'set-html-extra-example' => array(
        'locator' => 'h1',
        'html'    => '{$value}',
        'var' => array(
            'set' => array(
                'value' => 'Welcome to %sWebino%s',
            ),
            'helper' => array(
                'value' => array(
                    'sprintf' => array(
                        '{$value}',
                        '<span class="zf-green">',
                        '</span>',
                    ),
                ),
            ),
        ),
    ),
);
