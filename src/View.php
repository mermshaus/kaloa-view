<?php
/**
 * This file is part of the kaloa/view package.
 *
 * For full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Kaloa\View;

use Closure;

/**
 * Basic view class.
 */
class View
{
    /** @var array Variables set for this view. */
    private $__vars;

    /** @var Closure The function used by the escape method. */
    private $__escapeFunction;

    /**
     * Initializes the instance.
     */
    public function __construct()
    {
        $this->__vars = array();

        $this->__escapeFunction = function ($string) {
            return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        };
    }

    /**
     * Sets the escape function used by the escape method.
     *
     * @param Closure $escapeFunction New escape function.
     */
    public function setEscapeFunction(Closure $escapeFunction)
    {
        $this->__escapeFunction = $escapeFunction;
    }

    /**
     * Assigns a variable.
     *
     * @param string $name Key to bind variable to.
     * @param mixed  $value Value for key.
     */
    public function __set($name, $value)
    {
        $this->__vars[$name] = $value;
    }

    /**
     * Returns the value of an assigned variable.
     *
     * @param  string $name Key to get value for.
     * @return mixed Value or null if not set.
     */
    public function __get($name)
    {
        return (isset($this->__vars[$name])) ? $this->__vars[$name] : null;
    }

    /**
     * Renders a template file.
     *
     * @param string $template Template file to render.
     * @param array  $vars Additional variables might be assigned.
     */
    public function render($template, array $vars = array())
    {
        foreach ($vars as $key => $value) {
            if (is_string($key)) {
                $this->{$key} = $value;
            }
        }

        ob_start();

        include $template;

        return ob_get_clean();
    }

    /**
     * Escapes a string.
     *
     * @param  string $string String to escape.
     * @return string Escaped string.
     */
    public function escape($string)
    {
        $escapeFunction = $this->__escapeFunction;

        return $escapeFunction($string);
    }

    /**
     * Removes all assigned variables.
     */
    public function clear()
    {
        $this->__vars = array();
    }
}
