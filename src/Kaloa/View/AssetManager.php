<?php

namespace Kaloa\View;

class AssetManager
{
    protected $assets;

    public function __construct()
    {
        $this->assets['js'] = array();
        $this->assets['css'] = array();
    }

    public function addJavaScript($js)
    {
        $this->assets['js'][] = $js;
        return $this;
    }

    public function addStylesheet($css)
    {
        $this->assets['css'][] = $css;
        return $this;
    }

    public function css($css)
    {
        return $this->addStylesheet($css);
    }

    public function js($js)
    {
        return $this->addJavaScript($js);
    }

    public function generate()
    {
        $s = array();

        foreach ($this->assets['css'] as $file) {
            $s[] = '<link rel="stylesheet" type="text/css" href="' . $file . '" />';
        }

        foreach ($this->assets['js'] as $file) {
             if (is_array($file) && $file['type'] === 'cc') {
                $s[] = '<!--[if '.$file['value'].']>';
              $s[] = '<script src="' . $file['file'] . '"></script>';
             } else {
              $s[] = '<script src="' . $file . '"></script>';
             }

            if (is_array($file) && $file['type'] === 'cc') {
                $s[] = '<![endif]-->';
            }
        }

        return implode("\n", $s);
    }
}
