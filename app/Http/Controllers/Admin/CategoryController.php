<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
Use Toastr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'name'=>'required|min:3|unique:categories|max:10',
            'image'=>'required|mimes:jpeg,jpg,png,bmp'
        ]);


        //get image from request
        $image = file('image');
        $slug= Str::slug($request->name);

        if(isset($image)){
            $cDate= Carbon::now()->toDateString();
            $imageName=$slug.'-'.$cDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check category directory exists or not
            if(!Storage::disk('public')->exists('category')){
                Storage::disk('public')->makeDirectory('category');
            }
            //resize image for category and upload
            $category= Image::make($image)->resize(1600,400)->save();
            Storage::disk('public')->put('category/'.$imageName,$category);

            //check slider folder in category directory exists or not
            if(!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }
            //resize image for slider and upload
            $slider= Image::make($image)->resize(500,300)->save();
            Storage::disk('public')->put('category/slider/'.$imageName,$slider);

        }else{
            $imageName='default.png';
        }
        $category = new Category();
        $category->name= $request->name;
        $category->slug= $slug;
        $category->image=$imageName;
        $category->save();

        Toastr::success('Category added successfully','Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return  view('Admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'=>'required',
        ]);
        $category= Category::find($category->id);
        $category->name= $request->name;
        $category->slug= Str::slug($request->name);
        $category->save();

        Toastr::success('Category updated successfully','Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {

        $category=Category::find($category->id);
        $category->delete();
        Toastr::success('Category deleted successfully','Success');
        return redirect()->route('admin.category.index');
    }
}
