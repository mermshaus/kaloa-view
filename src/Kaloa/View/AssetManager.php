<?php
/**
 * Kaloa Library (http://www.kaloa.org/)
 *
 * @license http://www.kaloa.org/license.txt MIT License
 */

namespace Kaloa\View;

/**
 * Helper class to add CSS/JS assets to an HTML document.
 */
class AssetManager
{
    /**
     * List of assets managed by this instance.
     *
     * @var array
     */
    private $assets;

    /**
     * Initializes the instance.
     */
    public function __construct()
    {
        $this->assets['js'] = array();
        $this->assets['css'] = array();
    }

    /**
     * Adds a path to a JavaScript file to the managed assets.
     *
     * @param string $path Path to JavaScript file.
     */
    public function addJavaScript($path)
    {
        $this->assets['js'][] = $path;
    }

    /**
     * Adds a path to a CSS file to the managed assets.
     *
     * @param string $path Path to CSS file.
     */
    public function addStylesheet($path)
    {
        $this->assets['css'][] = $path;
    }

    /**
     * Wraps an IE conditional comment around a string.
     *
     * @param string $string
     * @param string $condition
     * @return string
     */
    private function wrapWithConditionalComment($string, $condition)
    {
        $html = array();

        $html[] = '<!--[if ' . $condition . ']>';
        $html[] = $string;
        $html[] = '<![endif]-->';

        return $html;
    }

    /**
     * Generates HTML output.
     *
     * @return string Generated HTML output.
     */
    public function generate()
    {
        $html = array();

        foreach ($this->assets['css'] as $file) {
            $path = $file;

            if (is_array($file)) {
                $path = $file['file'];
            }

            $line = '<link rel="stylesheet" type="text/css" href="'
                    . $path . '" />';

            if (is_array($file) && $file['type'] === 'cc') {
                $html = array_merge(
                    $html,
                    $this->wrapWithConditionalComment($line, $file['value'])
                );
            } else {
                $html[] = $line;
            }
        }

        foreach ($this->assets['js'] as $file) {
            $path = $file;

            if (is_array($file)) {
                $path = $file['file'];
            }

            $line = '<script src="' . $path . '"></script>';

            if (is_array($file) && $file['type'] === 'cc') {
                $html = array_merge(
                    $html,
                    $this->wrapWithConditionalComment($line, $file['value'])
                );
            } else {
                $html[] = $line;
            }
        }

        return implode("\n", $html);
    }
}
