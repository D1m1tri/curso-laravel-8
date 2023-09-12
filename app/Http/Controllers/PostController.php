<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;

class PostController extends Controller {

    // INDEX
    public function index() {
        $posts = Post::latest()->paginate();
        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }


    // CREATE
    public function create() {
        return view('admin.posts.create');
    }


    // STORE
    public function store(StoreUpdatePost $request) {
        // dd($request->all());
        Post::create($request->all());
        return redirect()
            ->route('posts.index')
            ->with('message', 'Post created successfully!');
    }


    // SHOW
    public function show($id) {
        // $post = Post::where('id', $id)->first();
        if (!$post = Post::find($id))
            return redirect()->route('posts.index');
        return view('admin.posts.show', [
            'post' => $post,
        ]);
    }


    // DESTROY
    public function destroy($id) {
        if (!$post = Post::find($id))
            return redirect()->route('posts.index');
        $post->delete();
        return redirect()
            ->route('posts.index')
            ->with('message', 'Post deleted successfully!');
    }


    // EDIT
    public function edit($id) {
        if (!$post = Post::find($id))
            return redirect()->back();
        return view('admin.posts.edit', [
            'post' => $post,
        ]);
    }


    // UPDATE
    public function update(StoreUpdatePost $request, $id) {
        if (!$post = Post::find($id))
            return redirect()->back();
        $post->update($request->all());
        return redirect()
            ->route('posts.index')
            ->with('message', 'Post updated successfully!');
    }
}
