<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller {

    // INDEX
    public function index() {
        $posts = Post::latest()->paginate(1);
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
        $data = $request->all();
        if ($request->image->isValid()) {

            $nameFile = Str::of($request->title)->slug('-') . '.' . $request->image->getClientOriginalExtension();

            $image = $request->image->storeAs('posts', $nameFile);
            $data['image'] = $image;
        }
        // dd($request->all());
        Post::create($data);
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
        if (Storage::exists($post->image))
            Storage::delete($post->image);
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
        $data = $request->all();
        if ($request->image->isValid()) {
            Storage::exists($post->image) ? Storage::delete($post->image) : '';
            $nameFile = Str::of($request->title)->slug('-') . '.' . $request->image->getClientOriginalExtension();
            $image = $request->image->storeAs('posts', $nameFile);
            $data['image'] = $image;
        }
        $post->update($data);
        return redirect()
            ->route('posts.index')
            ->with('message', 'Post updated successfully!');
    }

    // SEARCH
    public function search(Request $request) {
        $filters = $request->except('_token');
        $posts = Post::where('title', 'LIKE', "%{$request->search}%")
            ->orWhere('content', 'LIKE', "%{$request->search}%")
            ->paginate(1);
        return view('admin.posts.index', [
            'posts' => $posts,
            'filters' => $filters,
        ]);
    }
}
