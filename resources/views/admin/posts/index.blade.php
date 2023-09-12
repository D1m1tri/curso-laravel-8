<a href="{{ route('posts.create') }}">Criar novo post</a>
<hr>

@if (session('message'))
    <div>
        {{ session('message') }}
    </div>
@endif

<h1>Posts</h1>
<ul>
    @foreach ($posts as $post)
        <li>
            <a href="{{ route('posts.show', $post->id) }}">
                {{ $post->title }}
            </a>
        </li>
    @endforeach
</ul>

<hr>

{{ $posts->links() }}
