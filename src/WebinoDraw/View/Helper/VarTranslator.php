<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_View
 */

namespace WebinoDraw\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This component is used to replace variables in array
 * with values in the other array.
 *
 * The first array is a specification with custom options
 * with {$variable} in values.
 *
 * The second array contains data by variable names like
 * keys. Those {$variable} will be substituted with data.
 *
 * Custom options accepted by this component:
 *
 * <pre>
 * 'var' => array(
 *   'default' => array(
 *     'customvar' => 'customval',      // if variable is empty use default value
 *   ),
 *   'helper' => array(
 *     'varname' => array(
 *       'viewhelper' => array(
 *         'method' => array(array()),  // helper method params
 *       ),
 *       'function' => array(array()),  // function params
 *     ),
 *   ),
 * ),
 * </pre>
 *
 * By those custom options this component call view helpers
 * and functions over those {$variable}. This is useful because
 * you can for example generate whole head link and many more.
 *
 * @package     WebinoDraw_View
 * @subpackage  Helper
 */
class VarTranslator extends AbstractHelper
{
    /**
     * Pattern of variable
     */
    const VAR_PATTERN = '{$%s}';

    /**
     * Translate {$variables} in $spec values with data in $translation.
     *
     * @param  array $spec Associative array with variables in values, and custom options.
     * @param  array $translation Data to substitute variables.
     * @return array Translated $spec.
     */
    public function __invoke(array $spec, array $translation)
    {
        // default variables
        empty($spec['var']['default']) or
            $translation = $this->translationDefaults($translation, $spec['var']['default']);

        // variable helpers
        empty($spec['var']['helper']) or
            $translation = $this->applyHelper($translation, $spec['var']['helper']);

        $this->translate($spec, $this->array2Translation($translation));
        return $spec;
    }

    /**
     * Apply view helpers and functions on variables.
     *
     * @param  array $translation Variables with values to modify.
     * @param  array $spec Helper options.
     * @return array Array with modified values.
     */
    public function applyHelper(array $translation, array $spec)
    {
        foreach ($spec as $key => $value) {
            // skip undefined
            if (!array_key_exists($key, $translation)) {
                continue;
            }
            foreach ($value as $helper => $options) {
                if (function_exists($helper)) {
                    $this->translate(
                        $options,
                        $this->array2translation($translation)
                    );
                    $translation[$key] = call_user_func_array($helper, $options);
                } else {
                    $plugin = $this->view->plugin($helper);
                    foreach ($options as $fc => $calls) {
                        foreach ($calls as $params) {
                            $this->translate(
                                $params,
                                $this->array2translation($translation)
                            );
                            $plugin = call_user_func_array(
                                array($plugin, $fc),
                                $params
                            );
                            $translation[$key].= (string) $plugin;
                        }
                    }
                }
            }
        }
        return $translation;
    }

    /**
     * Set defaults into translation.
     *
     * @param array $translation
     * @param array $defaults
     * @return array
     */
    public function translationDefaults(array $translation, array $defaults)
    {
        foreach ($defaults as $key => $value) {
            if (empty($translation[$key])) {
                $translation[$key] = $value;
            }
        }
        return $translation;
    }

    /**
     * Transform varname into {$varname}.
     *
     * @param string $key
     * @return string
     */
    public function key2Var($key)
    {
        return sprintf(self::VAR_PATTERN, $key);
    }

    /**
     * Return true if {$var} is in the string.
     *
     * @param string $string
     * @return bool
     */
    public function stringHasVar($string)
    {
        $pattern = str_replace('%s', '[^\}]+', preg_quote(self::VAR_PATTERN));
        return (bool) preg_match('~' . $pattern . '~', $string);
    }

    /**
     * Transform simple array keys to {$var} like.
     *
     * @param array $array
     * @return array
     */
    public function array2Translation(array $array)
    {
        foreach ($array as $key => $value) {
            $array[$this->key2Var($key)] = $value;
            unset($array[$key]);
        }
        return $array;
    }

    /**
     * Replace {$var} in $subject with data from $translation.
     *
     * @param string|array $subject
     * @param array $translation
     * @return \WebinoDraw\View\Helper\VarTranslator
     */
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

    /**
     * Replace {$var} in string with data from translation.
     *
     * @param type $str
     * @param array $translation
     * @return type
     */
    public function translateString($str, array $translation)
    {
        foreach ($translation as $key => $value) {
            if (is_array($value)) {
                if ($key === $str) {
                    return $value;
                }
            }
            $str = str_replace($key, $value, $str);
        }
        return $str;
    }
}
