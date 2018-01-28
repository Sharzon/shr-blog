<?php

$this->register('get', '/post', 'PostController@index');
$this->register('get', '/post/{id}', 'PostController@show');
$this->register('post', '/post', 'PostController@store');
$this->register('put', '/post/{id}', 'PostController@update');
$this->register('delete', '/post/{id}', 'PostController@destroy');
// $this->register('delete', '/ololoshka', 'ApiController@ololoshka');