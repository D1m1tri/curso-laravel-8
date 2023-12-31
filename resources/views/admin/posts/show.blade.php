@extends('admin.layouts.app')

@section('title', 'Detalhes do Post \'' . $post->title . '\'')

@section('content')
    <a href="{{ route('posts.edit', $post->id) }}">Editar</a>
    <h1>Detalhes do Post '{{ $post->title }}'</h1>

    <ul>
        <li><strong>Título: </strong>{{ $post->title }}</li>
        <li><strong>Conteúdo: </strong></br>{{ $post->content }}</li>
    </ul>

    <hr>

    <form action="{{ route('posts.destroy', $post->id) }}" method="post">
        @csrf
        <input type="hidden" name="_method" value="DELETE">

        <button type="submit">Deletar o(a) {{ $post->title }}</button>
    </form>
@endsection
