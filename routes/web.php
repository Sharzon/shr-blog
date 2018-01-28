<?php

$this->register('get', '/', 'PostController@webList');
$this->register('get', '/post-list', 'PostController@webList');
$this->register('get', '/post/new', 'PostController@newPost');
$this->register('get', '/post/{id}', 'PostController@showPost');
$this->register('get', '/post/edit/{id}', 'PostController@editPost');


$this->register('get', '/login', 'UserController@loginPage');
$this->register('post', '/login', 'UserController@login');
$this->register('get', '/logout', 'UserController@logout');
