<?php

namespace App\Controller;

use App\Model\LoginKey;
/**
* 
*/
class Controller
{
    protected static function responseJson($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    protected static function responseError()
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        exit;
    }

    protected static function redirect($route)
    {
        header("Location: $route");
        exit;
    }
}