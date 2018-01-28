<?php

namespace App\Controller;

use App\View;
use App\Model\Post;
use App\Model\LoginKey;
/**
* 
*/
class PostController extends Controller
{
    public static function webList()
    {
        View::generate(
            'layout',
            'post-list',
            null,
            array_key_exists('key', $_COOKIE) && LoginKey::isKeyValid($_COOKIE['key'])
        );
    }

    public static function newPost()
    {
        View::generate(
            'layout',
            'post-new',
            null
        );
    }

    public static function editPost()
    {
        View::generate(
            'layout',
            'post-edit',
            null
        );
    }

    public static function showPost()
    {
        View::generate(
            'layout',
            'post',
            null
        );
    }

    public static function index($vars, $input)
    {
        $posts = Post::getAllAsArrays();

        static::responseJson($posts);
    }

    public static function show($vars)
    {
        static::responseJson(
            Post::find($vars['id'])->toArray()
        );
    }

    public static function store($vars, $input)
    {
        $post = new Post;
        $post['title'] = $input->title;
        $post['body'] = $input->body;
        $post->save();

        static::responseJson($post->toArray());
    }

    public static function update($vars, $input)
    {
        $post = Post::find($vars['id']);
        if (isset($input->title)) {
            $post['title'] = $input->title;
        }
        if (isset($input->body)) {
            $post['body'] = $input->body;
        }
        $post->save();

        static::responseJson($post->toArray());
    }

    public static function destroy($vars)
    {
        $post = Post::find($vars['id']);
        $post->delete();
    }
}