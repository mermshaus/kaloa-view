<?php

/*
 * This file is part of the kaloa/view package.
 *
 * For full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Kaloa\Tests;

use Kaloa\View\View;
use PHPUnit_Framework_TestCase;

/**
 *
 */
class ViewTest extends PHPUnit_Framework_TestCase
{
    public function testValuesCanBeCleared()
    {
        $view = new View();

        $this->assertEquals(null, $view->title);

        $view->title = 'Foo';

        $this->assertEquals('Foo', $view->title);

        $view->clear();

        $this->assertEquals(null, $view->title);
    }

    public function testValuesCanBeSetOnRender()
    {
        $view = new View();

        $view->title = 'Foo';

        $view->render(__DIR__ . '/examples/empty', array('title' => 'Bar'));

        $this->assertEquals('Bar', $view->title);
    }

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
