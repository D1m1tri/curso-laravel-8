@extends('admin.layouts.app')

@section('title', 'Listagem dos posts')

@section('content')
    <a href="{{ route('posts.create') }}">Criar novo post</a>
    <hr>

    @if (session('message'))
        <div>
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('posts.search') }}" method="post">
        @csrf
        <input type="text" name="search" placeholder="Filtrar:">
        <button type="submit">Filtrar</button>
    </form>

    <h1>Posts</h1>
    <ul>
        @foreach ($posts as $post)
            <li>
                <a href="{{ route('posts.show', $post->id) }}">
                    <img src="{{ url("storage/{$post->image}") }}" alt = "{{ $post->title }}" style="max-width: 100px;">
                    <br>
                    {{ $post->title }}
                </a>
            </li>
        @endforeach
    </ul>

    <hr>
    @if (isset($filters))
        {{ $posts->appends($filters)->links() }}
    @else
        {{ $posts->links() }}
    @endif
@endsection
