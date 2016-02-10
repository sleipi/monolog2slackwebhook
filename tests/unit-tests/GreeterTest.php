<?php

/**
 * Created by PhpStorm.
 * User: dominik
 * Date: 12.02.16
 * Time: 13:39
 */


namespace PCrew\Package\Skel;


class GreeterTest extends \PHPUnit_Framework_TestCase
{
    public function testGreet()
    {
        $greeter = new Greeter();
        $this->assertEquals("Hi tester,\nHave fun with this skeleton\n", $greeter->greet("tester"));
    }
}
