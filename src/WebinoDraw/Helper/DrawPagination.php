<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\Helper;

use WebinoDraw\Dom\NodeList;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Stdlib\ArrayUtils;

/**
 *
 */
class DrawPagination extends DrawElement
{
    /**
     * @var array
     */
    protected static $defaultSpec = [
        'paginator' => 'WebinoDrawPaginator',
        'var' => [
            'fetch' => [
                'pageHref' => 'page.href'
            ],
        ],
        'instructions' => [
            'snippet' => [
                'locator' => 'xpath=.',
                'html'    => '{$snippet}',

                'render' => [
                    'snippet' => 'webino-draw/snippet/pagination',
                ],
            ],
            'first' => [
                'locator' => 'xpath=.//li[1]/a[1]',
                'attribs' => [
                    'href'  => '{$pageHref}?{$first}{$params}',
                    'title' => '{$first}',
                ],
            ],
            'last' => [
                'locator' => 'xpath=.//li[last()]/a',
                'attribs' => [
                    'href'  => '{$pageHref}?{$last}{$params}',
                    'title' => '{$last}',
                ],
            ],
            // TODO do not use ?1 on the first page by default
            'pages' => [
                'locator' => 'xpath=.//li[2]',
                'loop' => [
                    'base' => 'pagesInRange',
                    'instructions' => [
                        'active' => [
                            'locator' => 'xpath=.',
                            'attribs' => [
                                'class' => '{$active}',
                            ],
                        ],
                        'value' => [
                            'locator' => 'a',
                            'value'   => '{$number}',

                            'attribs' => [
                                'href'  => '{$pageHref}?{$number}{$params}',
                                'title' => '{$number}',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var ServiceLocatorInterface
     */
    protected $services;

    public function __construct(ServiceLocatorInterface $services)
    {
        $this->services = $services;
    }

    public function addParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     * @return self
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        $spec          = ArrayUtils::merge(self::$defaultSpec, $spec);
        $paginatorName = $spec['paginator'];

        if (!$this->services->has($paginatorName)) {
            $nodes->remove();
            return $this;
        }

        /* @var $paginator \Zend\Paginator\Paginator */
        $paginator = $this->services->get($paginatorName);
        $pages     = $paginator->getPages();

        if (1 >= $pages->pageCount) {
            $nodes->remove();
            return $this;
        }

        $curPageNo    = $paginator->getCurrentPageNumber();
        $pagesInRange = [];

        foreach ($pages->pagesInRange as $pageNo) {
            $pagesInRange[] = [
                'number' => $pageNo,
                'active' => ($curPageNo == $pageNo) ? 'active' : '',
            ];
        }

        $this->setVars(
            array_merge(
                $this->getVars(),
                (array) $pages,
                [
                    'pagesInRange' => $pagesInRange,
                    'params'       => !empty($this->params)
                                      ? '&amp;' . http_build_query($this->params, '', '&amp;')
                                      : '',
                ]
            )
        );

        return parent::drawNodes($nodes, $spec);
    }
}
