<?php

/*
 * This file is part of the kaloa/view package.
 *
 * For full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Kaloa\Tests;

use Kaloa\View\AssetManager;
use PHPUnit_Framework_TestCase;

/**
 *
 */
class AssetManagerTest extends PHPUnit_Framework_TestCase
{
    public function testAssetsCanBeAddedAndOutput()
    {
        $manager = new AssetManager();

        $manager->addJavaScript('/path/to/jsfile.js?1');
        $manager->addJavaScript(
            array(
                'type' => 'cc',
                'value' => 'lte IE 7',
                'file' => '/path/to/jsfile.js?1'
            )
        );
        $manager->addJavaScript('http://example.org/test.js');

        $checkJs = <<<EOT
<script src="/path/to/jsfile.js?1"></script>
<!--[if lte IE 7]>
<script src="/path/to/jsfile.js?1"></script>
<![endif]-->
<script src="http://example.org/test.js"></script>
EOT;

        $this->assertEquals($checkJs, $manager->generate());

        $manager->addStylesheet(
            array(
                'type' => 'cc',
                'value' => 'lte IE 7',
                'file' => 'ie-screen.css'
            )
        );
        $manager->addStylesheet('/styles.css');

        $checkCss = <<<EOT
<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" href="ie-screen.css" />
<![endif]-->
<link rel="stylesheet" type="text/css" href="/styles.css" />
EOT;

        $this->assertEquals($checkCss . "\n" . $checkJs, $manager->generate());
    }
}
