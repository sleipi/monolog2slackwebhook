<?php

/**
 * Created by PhpStorm.
 * User: dominik
 * Date: 12.02.16
 * Time: 13:29
 */

namespace PCrew\Package\Skel;

class Greeter
{
    public function greet($name){
        return "Hi ". $name .",\nHave fun with this skeleton\n";
    }
}