<?php

namespace App\Model;

/**
* 
*/
class Post extends Model
{
    static protected $table = 'posts';
    static protected $id_field = 'id';
    static protected $fields = [
        'id',
        'created_at',
        'updated_at',
        'title',
        'body'
    ];
}