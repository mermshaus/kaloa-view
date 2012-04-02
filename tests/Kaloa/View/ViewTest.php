<?php

namespace Kaloa\Tests;

use PHPUnit_Framework_TestCase;
use Kaloa\View\View;

/**
 *
 * @author Marc Ermshaus <marc@ermshaus.org>
 */
class ViewTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $view = new View();

        $view->title = 'Ü > "Ä"';

        $output = $view->render(__DIR__ . '/examples/test.phtml');

        $this->assertEquals(file_get_contents(__DIR__ . '/examples/test.html'), $output);
    }
}
