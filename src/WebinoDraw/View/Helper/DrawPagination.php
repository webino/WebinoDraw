<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\View\Helper;

use WebinoDraw\Dom\NodeList;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 *
 */
class DrawPagination extends DrawElement implements ServiceLocatorAwareInterface
{
    /**
     * @var array
     */
    protected static $defaultSpec = array(
        'paginator' => 'WebinoDrawPaginator',
        'var' => array(
            'fetch' => array(
                'pageHref' => 'page.href'
            ),
        ),
        'instructions' => array(
            'snippet' => array(
                'locator' => 'xpath=.',
                'render' => array(
                    'snippet' => 'webino-draw/snippet/pagination',
                ),
                'html' => '{$snippet}',
            ),
            'first' => array(
                'locator' => 'xpath=.//li[1]/a[1]',
                'attribs' => array(
                    'href' => '{$pageHref}?{$first}',
                    'title' => '{$first}',
                ),
            ),
            'last' => array(
                'locator' => 'xpath=.//li[last()]/a',
                'attribs' => array(
                    'href' => '{$pageHref}?{$last}',
                    'title' => '{$last}',
                ),
            ),
            'pages' => array(
                'locator' => 'xpath=.//li[2]',
                'loop' => array(
                    'base' => 'pagesInRange',
                    'instructions' => array(
                        'active' => array(
                            'locator' => 'xpath=.',
                            'attribs' => array(
                                'class' => '{$active}',
                            ),
                        ),
                        'value' => array(
                            'locator' => 'a',
                            'value' => '{$number}',
                            'attribs' => array(
                                'href' => '{$pageHref}?{$number}',
                                'title' => '{$number}',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    );

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param NodeList $nodes
     * @param array $spec
     * @return DrawPagination
     */
    public function drawNodes(NodeList $nodes, array $spec)
    {
        // merge default
        $spec = array_merge_recursive(self::$defaultSpec, $spec);

        $services = $this->getServiceLocator()->getServiceLocator();
        $paginatorName = $spec['paginator'];

        if (!$services->has($paginatorName)) {
            $nodes->remove();
            return;
        }

        /* @var $paginator \Zend\Paginator\Paginator */
        $paginator = $services->get($paginatorName);
        $pages     = $paginator->getPages();

        if (1 >= $pages->pageCount) {
            $nodes->remove();
            return;
        }

        $curPageNo = $paginator->getCurrentPageNumber();
        $pagesInRange = array();

        foreach ($pages->pagesInRange as $pageNo) {

            $pagesInRange[] = array(
                'number' => $pageNo,
                'active' => ($curPageNo == $pageNo) ? 'active' : '',
            );
        }

        $this->setVars(
            array_merge(
                $this->getVars(),
                (array) $pages,
                array('pagesInRange' => $pagesInRange)
            )
        );

        return parent::drawNodes($nodes, $spec);
    }
}
