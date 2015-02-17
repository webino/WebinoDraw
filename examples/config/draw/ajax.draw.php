<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw;

return [
    'ajax-example-prepare' => [
        'locator' => 'head',
        'html'    => '{$_innerHtml}<script>jQuery(document).on("click", ".ajax-example a", function(){ jQuery.get($(this).attr("href"), function(data) { jQuery.each(data.fragment, function(selector, html) { jQuery(selector).replaceWith(html); }); if (data.extraTest) { $(".ajax-log").html(data.extraTest); } }, "json"); return false; });</script>',
    ],
    'ajax-example' => [
        'locator' => '.jumbotron',
        'html'    => '{$_innerHtml}<div class="ajax-example"><a href=".">AJAX</a> | <a href="?fragmentId=ajax-rand">AJAX SINGLE</a> | <a href="?ajaxExtra">AJAX EXTRA</a> : <strong class="ajax-fragment" id="ajax-time">{$time}</strong> - <strong class="ajax-fragment" id="ajax-rand">{$rand}</strong><br /><p class="ajax-log"></p></div>',

        'var'     => [
            'set'    => [
                'time' => '',
                'rand' => '',
            ],
            'helper' => [
                'time' => [
                    'time' => [],
                ],
                'rand' => [
                    'rand' => [],
                ],
            ],
        ],
    ],
];
