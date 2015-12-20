<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;


class PostController extends Controller
{

    private $post;

    public function __construct(Post $post)
    {

        $this->post = $post;
    }

    public function index()
    {
        $posts = $this->post->paginate(5);
        return view('posts.index', compact('posts'));
    }
}
