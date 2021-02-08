<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('Admin.post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::latest()->get();
        $tags= Tag::latest()->get();
        return view('Admin.post.create',compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title'=>'required',
            'categories'=>'required',
            'tags'=>'required',
            'body'=>'required',
            'image'=>'required|mimes:png,jpeg,jpg,bmp,tiff'
        ]);
        $image = $request->file('image');
        $slug= Str::slug($request->title);
        if(isset($image)){
            $cDate = Carbon::now()->toDateString();
            $imageName=$slug.'-'.$cDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('posts')){
                Storage::disk('public')->makeDirectory('posts');
            }
            $postImg= Image::make($image)->resize(1600,1066)->save();
            Storage::disk('public')->put('posts/'.$imageName,$postImg);
        }else{
            $imageName='default.png';
        }
        $post = new Post();
        $post->user_id= Auth::id();
        $post->title= $request->title;
        $post->slug= $slug;
        $post->image= $imageName;
        if(isset($request->status)){
            $post->status= true;
        }else{
            $post->status= false;
        }
        $post->is_approved=true;
        $post->body= strip_tags($request->body);
        $post->save();



        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);



        Toastr::success('Post saved successfully','success');
        return redirect()->route('admin.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags =Tag::all();
        return view('Admin.post.edit',compact('post','tags','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'=>'required',
            'categories'=>'required',
            'tags'=>'required',
            'body'=>'required',
            'image'=>'mimes:png,jpeg,jpg,bmp,tiff'
        ]);
        $image = $request->file('image');
        $slug= Str::slug($request->title);

        if(isset($image)){
            $cDate = Carbon::now()->toDateString();
            $imageName=$slug.'-'.$cDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('posts')){
                Storage::disk('public')->makeDirectory('posts');
            }
            //delete old post image
            if(Storage::disk('public')->exists('posts/'.$post->image)){
                Storage::disk('public')->delete('posts/'.$post->image);
            }
            $postImg= Image::make($image)->resize(1600,1066)->save();
            Storage::disk('public')->put('posts/'.$imageName,$postImg);
        }else{
            $imageName=$post->image;
        }

        $post->user_id= Auth::id();
        $post->title= $request->title;
        $post->slug= $slug;
        $post->image= $imageName;
        if(isset($request->status)){
            $post->status= true;
        }else{
            $post->status= false;
        }
        $post->is_approved=true;
        $post->body= strip_tags($request->body);
        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);



        Toastr::success('Post updated successfully','success');
        return redirect()->route('admin.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        Storage::disk('public')->delete('/posts/'.$post->image);
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('Post deleted successfully','Success');
        return redirect()->route('admin.category.index');
    }
}
