<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth;

class BlogController extends Controller
{
    public function posts()
    {
        return view('admin.blog.index', ['posts' => Post::all(), 'categories' => Category::all()]);
    }

    public function create()
    {
        return view('admin.blog.create', ['categories' => Category::all()]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'categories' => ['required', 'array'],
            'status' => ['required', 'string']
        ]);

        $post = new Post();

        $excerpt = $request->body;
        if(strlen($excerpt)>150) {
            substr_replace($excerpt, '...', 150);
        }

        $newArray = [];

        foreach ($request->categories as $category) {
            array_push($newArray, $category);
        }

        // $post = Post::create([
        //     'user_id' => Auth::user()->id,
        //     'title' => $request->title,
        //     'slug' => $request->slug,
        //     'body' => $request->body,
        //     'excerpt' => $excerpt,
        //     'status' => $request->status,
        //     'published_at' => $request->published_at,
        // ]);

        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = $request->body;
        $post->excerpt = $excerpt;
        $post->status = $request->status;
        $post->published_at = $request->published_at;

        $post->save();
        $post->categories()->sync($newArray);

        return redirect('/admin/posts')->with('status', "$post->title was created.");
    }

    public function update($id)
    {
        $post = Post::find($id);
        return view('admin.blog.edit', ['posts' => $post, 'categories' => Category::all()]);
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'status' => ['required', 'string'],
        ]);

        $post = Post::findOrFail($request->id);

        $excerpt = $request->body;
        if(strlen($excerpt)>150) {
            substr_replace($excerpt, '...', 150);
        }

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = $request->body;
        $post->excerpt = $excerpt;
        $post->status = $request->status;
        $post->published_at = $request->published_at;

        $post->save();

        return redirect('/admin/posts')->with('status', "$post->title was edited.");
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        Post::destroy($id);

        return redirect('/admin/posts')->with('status', "$post->title was deleted.");
    }
}
