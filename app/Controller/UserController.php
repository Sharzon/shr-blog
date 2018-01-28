<?php

namespace App\Controller;

use App\View;
use App\Model\LoginKey;
/**
* 
*/
class UserController extends Controller
{
    protected static $username = "username";
    protected static $password = "password";

    public static function loginPage($vars, $input)
    {
        View::generate(
            'layout',
            'login',
            $input,
            array_key_exists('key', $_COOKIE) && LoginKey::isKeyValid($_COOKIE['key'])
        );
    }

    public static function login($vars, $input)
    {
        if (static::$username == $input->username && static::$password == $input->password) {
            $key = LoginKey::createKey();

            setcookie('key', $key, time()+60*60*24);

            static::redirect('/');
        } else {
            static::redirect('/login?wrong');
        }
    }

    public static function logout()
    {
        setcookie('key', '', time());
        static::redirect('/');
    }
}