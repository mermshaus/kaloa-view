<?php

namespace Kaloa\View;

use Closure;

/**
 *
 * @author Marc Ermshaus <marc@ermshaus.org>
 */
class View
{
    /**
     *
     * @var array
     */
    protected $__vars;

    /**
     *
     * @var Closure
     */
    protected $__escapeFunction;

    /**
     *
     */
    public function __construct()
    {
        $this->__vars = array();

        $this->__escapeFunction = function ($s) {
            return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
        };
    }

    /**
     *
     * @param Closure $f
     */
    protected function setEscapeFunction(Closure $f)
    {
        $this->__escapeFunction = $f;
    }

    /**
     *
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        $this->__vars[$name] = $value;
    }

    /**
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return (isset($this->__vars[$name])) ? $this->__vars[$name] : null;
    }

    /**
     *
     * @param string $template
     * @param array  $vars
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
     *
     * @param  string $s
     * @return string
     */
    public function escape($s)
    {
        $f = $this->__escapeFunction;

        return $f($s);
    }

    /**
     *
     */
    public function clear()
    {
        $this->__vars = array();
    }
}
