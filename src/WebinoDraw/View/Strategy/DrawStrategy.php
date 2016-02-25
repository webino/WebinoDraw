<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoDraw\View\Strategy;

use WebinoDraw\Exception;
use Zend\Http\PhpEnvironment\Response;
use Zend\View\ViewEvent;

/**
 * Draw XHTML with this view strategy
 */
class DrawStrategy extends AbstractDrawStrategy
{
    /**
     * Application service name
     */
    const SERVICE = 'WebinoDrawStrategy';

    /**
     * @param ViewEvent $event
     * @throws \Exception
     */
    public function injectResponse(ViewEvent $event)
    {
        if (!$this->shouldRespond($event)) {
            return;
        }

        /* @var $response Response */
        $options  = $this->draw->getOptions();
        $response = $event->getResponse();
        $body     = $response->getBody();
        $spec     = $options->getInstructions();
        $model    = $event->getModel();
        $isXml    = $this->resolveIsXml($response);

        try {
            $response->setContent(
                $this->draw->draw(
                    $body,
                    $spec,
                    $this->collectModelVariables($model),
                    $isXml
                )
            );

        } catch (Exception\DrawException $exc) {
            $_exc = $exc;
            while ($subExc = $_exc->getPrevious()) {
                $_exc = $subExc;

                if ($subExc instanceof Exception\ExceptionalDrawExceptionInterface) {
                    $model->setVariables($subExc->getDrawVariables());
                    $response->setContent(
                        $this->draw->draw(
                            $body,
                            $spec,
                            $this->collectModelVariables($model),
                            $isXml
                        )
                    );
                    return;
                }
            }
            throw $exc;

        } catch (\Exception $exc) {
            throw $exc;
        }
    }

    /**
     * @param Response $response
     * @return bool
     */
    private function resolveIsXml(Response $response)
    {
        $contentType = $response->getHeaders()->get('content-type');
        if (empty($contentType)) {
            return false;
        }

        return ('text/xml' === $contentType->getMediaType());
    }
}
