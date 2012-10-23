<?php
/**
 * Webino (http://zf.webino.org/)
 *
 * @copyright   Copyright (c) 2012 Peter Bačinský (http://www.bacinsky.sk/)
 * @license     New BSD License
 * @package     WebinoDraw
 */

namespace Webino\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * @category    Webino
 * @package     WebinoDraw
 * @subpackage  ViewHelper
 * @author      Peter Bačinský <peter@bacinsky.sk>
 */
class VarTranslator extends AbstractHelper
{
    /**
     * Pattern of variable
     */
    const VAR_PATTERN = '{$%s}';

    public function __invoke($spec, array $vars)
    {        
        // default variables
        empty($spec['var']['default']) or
            $vars = $this->translationDefaults($vars, $spec['var']['default']);

        // variable helpers
        empty($spec['var']['helper']) or
            $vars = $this->applyHelper($vars, $spec['var']['helper']);

        $this->translate($spec, $this->array2Translation($vars));
        return $spec;
    }

    public function applyHelper(array $translation, array $spec)
    {
        foreach ($spec as $key => $value) {
            if (!array_key_exists($key, $translation)) continue; // skip undefined
            foreach ($value as $helper => $functions) {
                if (function_exists($helper)) {
                    $this->translate(
                        $functions, $this->array2translation($translation)
                    );
                    $translation[$key] = call_user_func_array($helper, $functions);
                } else {
                    $plugin = $this->view->plugin($helper);
                    foreach ($functions as $fc => $calls) {
                        foreach ($calls as $params) {
                            $this->translate(
                                $params, $this->array2translation($translation)
                            );
                            $plugin = call_user_func_array(
                                array($plugin, $fc), $params
                            );
                            $translation[$key].= (string) $plugin;
                        }
                    }
                }
            }
        }
        return $translation;
    }

    public function translationDefaults(array $translation, array $vars)
    {
        foreach ($vars as $key => $value) {
            if (!empty($translation[$key])) continue;
            $translation[$key] = $value;
        }
        return $translation;
    }
    
    public function key2Var($key)
    {
        return sprintf(self::VAR_PATTERN, $key);
    }
    
    public function stringHasVar($string)
    {
        $pattern = str_replace('%s', '[^\}]+', preg_quote(self::VAR_PATTERN));
        return preg_match('~' . $pattern . '~', $string);
    }

    public function array2Translation(array $vars)
    {
        foreach ($vars as $key => $value) {
            $vars[$this->key2Var($key)] = $value;
            unset($vars[$key]);
        }
        return $vars;
    }

    public function translate(&$subject, array $translation)
    {
        if (is_string($subject)) {
            return $this->translateString($subject, $translation);
        }
        foreach ($subject as &$param) {
            if (is_array($param)) {
                $this->translate($param, $translation);
                continue;
            }
            $param = $this->translateString($param, $translation);
        }
        return $this;
    }

    public function translateString($str, array $translation)
    {
        foreach ($translation as $key => $value) {
            if (is_array($value)) {
                if ($key == $str) $str = $value;
            } else {
                $str = str_replace($key, $value, $str);
            }
        }
        return $str;
    }

}

