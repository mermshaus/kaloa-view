<?php
/**
 * Kaloa Library (http://www.kaloa.org/)
 *
 * @license http://www.kaloa.org/license.txt MIT License
 */

namespace Kaloa\Tests;

use PHPUnit_Framework_TestCase;

use Kaloa\View\AssetManager;

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
