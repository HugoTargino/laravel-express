@extends('template.template')

@section('title') Blog @stop


@section('content')
    <h1>Posts</h1>

    @foreach($posts as $post)
        <h2>{{$post->title}}</h2>
        <p>{{$post->content}}</p>

        <h4>Comments</h4>
        @foreach($post->comments as $comment)
            <b>Nome:</b> {{$comment->name}} </br>
            <b>Comentario:</b> {{$comment->comment}} <br>


        @endforeach
        <h5>Tags:</h5>
        {{$post->tagList}} </br>
        @foreach($post->tags as $tag)
            {{$tag->name}}
        @endforeach
        <hr>
    @endforeach

    {!! $posts->render() !!}
@stop