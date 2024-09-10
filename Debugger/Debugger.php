<?php

namespace TwoCoffeCups\PHPErrorHandler\Debugger;

class Debugger
{
    /**
     * Show error and die
     * @param ...$vars
     * @return void
     */
    public static function dd(...$vars)
    {
        foreach ($vars as $var){
            echo "<pre>";
            print_r($var);
            echo "</pre>";
        }
        echo "<br>";
        die();
    }

    /**
     * Show error
     * @param ...$vars
     * @return void
     */
    public static function dump(...$vars)
    {
        foreach ($vars as $var){
            echo "<pre>";
            print_r($var);
            echo "</pre>";
        }
        echo "<br>";
    }
}