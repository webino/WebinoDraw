<?php
/**
 * Webino (https://github.com/webino/)
 *
 * @link        https://github.com/webino/WebinoDraw/ for the canonical source repository
 * @copyright   Copyright (c) 2012 Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 * @package     WebinoDraw_Stdlib
 */

namespace WebinoDraw\Stdlib;

use Zend\ServiceManager\AbstractPluginManager;

/**
 * Replace variables in array with values in the other array.
 *
 * The first array is a specification with custom options
 * with {$variable} in values.
 *
 * The second array contains data by variable names like
 * keys. Those {$variable} will be substituted with data.
 *
 * @category    Webino
 * @package     WebinoDraw_Stdlib
 */
class VarTranslator
{
    /**
     * Pattern of variable
     */
    const VAR_PATTERN = '{$%s}';

    /**
     * Transform varname into {$varname}.
     *
     * @param  string $key
     * @return string
     */
    public function key2var($key)
    {
        return sprintf(self::VAR_PATTERN, $key);
    }

    /**
     * Return true if {$var} is in the string.
     *
     * @param  string $string
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
     * @param  array $array
     * @return array
     */
    public function array2translation(array $array)
    {
        foreach ($array as $key => $value) {
            $array[$this->key2var($key)] = $value;
            unset($array[$key]);
        }
        return $array;
    }

    /**
     * Replace {$var} in string with data from translation.
     *
     * If $str = {$var} and translation has item with key {$var} = array,
     * immediately return this array.
     *
     * @param  string $string
     * @param  array $translation
     * @return string
     */
    public function translateString($string, array $translation)
    {
        $pattern = str_replace('%s', '[^\}]+', preg_quote(self::VAR_PATTERN));
        $match   = array();

        preg_match_all('~' . $pattern . '~', $string, $match);
        if (empty($match[0])) {
            return $string;
        }
        foreach ($match[0] as $key) {
            if (array_key_exists($key, $translation)) {
                $string = str_replace($key, $translation[$key], $string);
            }
        }
        return $string;
    }

    /**
     * Replace {$var} in $subject with data from $translation.
     *
     * @param  string|array $subject
     * @param  array $translation
     * @return \WebinoDraw\Stdlib\VarTranslator
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
     *
     * @param  array $translation
     * @param  array $defaults
     * @return \WebinoDraw\Stdlib\VarTranslator
     */
    public function translationMerge(array &$translation, array $defaults)
    {
        foreach ($defaults as $key => $value) {
            $translation[$key] = $this->translate($value, $translation);
        }
        return $this;
    }

    /**
     * Set defaults into translation.
     *
     * @param  array $translation
     * @param  array $defaults
     * @return array
     */
    public function translationDefaults(array &$translation, array $defaults)
    {
        foreach ($defaults as $key => $value) {
            if (empty($translation[$key])) {
                $translation[$key] = $this->translate($value, $translation);
            }
        }
        return $this;
    }

    /**
     * Fetch custom variables to translation
     *
     * example of properties:
     *
     * $translation = array(
     *     'value' => array(
     *         'in' => array(
     *             'the' => array(
     *                 'depth' => 'valueInTheDepth',
     *             ),
     *         ),
     *     ),
     * );
     *
     * example of options:
     *
     * $options = array(
     *     'customVar' => 'value.in.the.depth',
     * );
     *
     * @param array $translation
     * @param array $options
     *
     * @return Webino_ViewHelper_VarTranslator
     */
    public function translationFetch(array &$translation, array $options)
    {
        foreach ($options as $varName => $varBase) {

            $value = $translation;
            $frags = explode('.', $varBase);

            foreach ($frags as $baseKey) {
                // undefined
                if (empty($value[$baseKey])) {
                    $value = null;
                    break;
                }

                $value = &$value[$baseKey];
            }
            $translation[$varName] = &$value;
        }
        return $this;
    }

    /**
     * Apply view helpers and functions on variables.
     *
     * Call user function if exists else call helper.
     *
     * @param  array $translation Variables with values to modify.
     * @param  array $spec Helper options.
     * @param  \Zend\ServiceManager\AbstractPluginManager $pluginManager Helper loader.
     * @return array Array with data instead {$var}.
     */
    public function applyHelper(array &$translation, array $spec, AbstractPluginManager $pluginManager)
    {
        foreach ($spec as $key => $value) {
            // skip undefined
            if (!array_key_exists($key, $translation)) {
                continue;
            }
            foreach ($value as $helper => $options) {
                // we can use functions first
                if (function_exists($helper)) {
                    $this->translate(
                        $options,
                        $this->array2translation($translation)
                    );
                    $translation[$key] = call_user_func_array($helper, $options);
                } else {
                    // use helper from plugin manager
                    $plugin = $pluginManager->get($helper);
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
        return $this;
    }
}
