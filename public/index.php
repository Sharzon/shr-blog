<?php

require_once __DIR__ . '/../vendor/autoload.php';

// var_dump(array_slice(explode('/', $_SERVER['REQUEST_URI']), 1));
use App\Route;

Route::start();
// 
// echo phpversion();