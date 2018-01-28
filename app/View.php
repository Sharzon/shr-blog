<?php

namespace App;

/**
* 
*/
class View
{
    public static function getView($view_name, $data = [], $logged = false)
    {
        static::generate($view_name);
    }


    public static function generate($template_view, $content_view = null, $data = [], $logged = false)
    {
        include __DIR__ . "/../views/$template_view.php";
    }
}