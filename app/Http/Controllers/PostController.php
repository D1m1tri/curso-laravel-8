<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:3',
        ]);

        Post::create($request->all());

        return redirect()->route('posts.index');
    }
}
