<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostsAdminController extends Controller
{

    private $post;

    public function __construct(Post $post)
    {

        $this->post = $post;
    }

    public function index()
    {
        $posts = $this->post->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(PostRequest $request)
    {
        $post = $this->post->create($request->all());
        $post->tags()->sync($this->getTagsIds($request->tags));
        return redirect()->route('admin.posts.index');
    }

    public function edit($id)
    {
        $post = $this->post->find($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update($id, PostRequest $request)
    {
        $this->post->find($id)->update($request->all());
        $post = $this->post->find($id);
        $post->tags()->sync($this->getTagsIds($request->tags));
        return redirect()->route('admin.posts.index');
    }

    public function destroy($id)
    {
        $this->post->find($id)->delete();
        return redirect()->route('admin.posts.index');
    }

    private function getTagsIds($tags)
    {
        $tagsList = array_filter(array_map('trim', explode(',', $tags)));
        $tagsIDs = [];
        /*

            explode = funcao em php para colocar os dados em um array ex: oi, mundo = array[0 => "oi", 1 => " mundo"]
            array_map + trim = funcao em php para ignorar os espacos de cada dado ex: array[0 => "oi", 1 => "mundo"]
            array_filter = funcao em php para igonar um dado vazio ex: oi, ,mundo = array[0 => "oi", 1 => " ", 2 => " mundo"]
            usando a funcao: array[0 => "oi", 1 => " mundo"]

          */

        foreach($tagsList as $tagName)
        {
            $tagsIDs[] = Tag::firstOrCreate(['name' => $tagName])->id;
        }
        return $tagsIDs;
    }
}
