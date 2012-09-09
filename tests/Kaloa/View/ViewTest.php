<?php
/**
 * Kaloa Library (http://www.kaloa.org/)
 *
 * @license http://www.kaloa.org/license.txt MIT License
 */

namespace Kaloa\Tests;

use PHPUnit_Framework_TestCase;

use Kaloa\View\View;

/**
 *
 */
class ViewTest extends PHPUnit_Framework_TestCase
{
    public function testHtmlTestSuiteSucceeds()
    {
        $view = new View();

        $view->title = 'Ü > "Ä"';

        $view->articles = range(1, 10);

        $output = $view->render(__DIR__ . '/examples/test.phtml');

        $this->assertEquals(
            file_get_contents(__DIR__ . '/examples/test.html'),
            $output
        );
    }

    public function testEscapeFunctionCanBeSet()
    {
        $view = new View();
        $view->setEscapeFunction(function ($string) {
            return '[escaped]' . $string . '[/escaped]';
        });
        $view->test = 'test';

        $output = $view->render(__DIR__ . '/examples/escaped.phtml');

        $this->assertEquals(
            file_get_contents(__DIR__ . '/examples/escaped.html'),
            $output
        );
    }
}
