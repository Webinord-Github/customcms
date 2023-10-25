<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'categories' => ['required', 'array'],
            'status' => ['required', 'string']
        ]);

        $post = new Post();

        $excerpt = $request->body;
        if(strlen($excerpt)>150) {
            substr_replace($excerpt, '...', 150);
        }

        $categories_selected = [];

        foreach ($request->categories as $category) {
            array_push($categories_selected, $category);
        }

        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = $request->body;
        $post->excerpt = $excerpt;
        $post->status = $request->status;
        $post->published_at = $request->published_at;

        $image_ext =  $request->image->extension();
        $image_name = strtolower(preg_replace("/\s+/", "", $request->title));
        $image_fullname = $image_name . '.' . $image_ext;
        Storage::putFileAs('public/img/posts', $request->image, $image_name . '.' . $image_ext);
        $post->image = $image_fullname;

        $post->save();
        $post->categories()->sync($categories_selected);

        return redirect('/admin/posts')->with('status', "$post->title was created.");
    }

    public function update($id)
    {
        $post = Post::findOrFail($id);
        $categories_selected = Post::find($id)->categories;
        return view('admin.blog.edit', ['post' => $post, 'categories' => Category::all(), 'categories_selected' => $categories_selected]);
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'categories' => ['required', 'array'],
            'status' => ['required', 'string']
        ]);

        $post = Post::findOrFail($request->id);

        $excerpt = $request->body;
        if(strlen($excerpt)>150) {
            substr_replace($excerpt, '...', 150);
        }

        $categories_selected = [];

        foreach ($request->categories as $category) {
            array_push($categories_selected, $category);
        }

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = $request->body;
        $post->excerpt = $excerpt;
        $post->status = $request->status;
        $post->published_at = $request->published_at;

        $image_name = strtolower(preg_replace("/\s+/", "", $request->title));
        if ($request->image != null) {
            Storage::delete('public/img/posts/' . $post->image);
            $image_ext =  $request->image->extension();
            $image_fullname = $image_name . '.' . $image_ext;
            Storage::putFileAs('public/img/posts', $request->image, $image_fullname);
        } else {
            $image_ext = pathinfo(storage_path('public/img/posts/' . $post->image), PATHINFO_EXTENSION);
            $image_fullname = $image_name . '.' . $image_ext;
            Storage::move('public/img/posts/' . $post->image, 'public/img/posts/' . $image_name . '.' . $image_ext);
        }
        $post->image = $image_fullname;

        $post->save();
        $post->categories()->sync($categories_selected);

        return redirect('/admin/posts')->with('status', "$post->title was edited.");
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        Post::destroy($id);
        $post->categories()->detach();

        return redirect('/admin/posts')->with('status', "$post->title was deleted.");
    }
}
