<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogTag;
use App\Models\Category;
use App\Models\Tag;

class apiController extends Controller
{
    public function blogIndex(){
        return Blog::all();
    }

    public function blogStore(Request $request){
        $this-> validate($request, [
            // 'blog'  => 'required',
            'content' => 'required',
            // 'blog_image' => 'image|nullable|max:1999',
            'category_id' => 'required' 
         ]);

        return Blog::create($request->all());
    }

    public function blogShow($id){
        return Blog::find($id);
    }

    public function blogShowCategory($id){
        $blog =Blog::find($id);
        $categoryId = $blog->category_id;
        return Category::find($categoryId);
    }

    public function blogShowTag($id){
        $blog =Blog::find($id);
        foreach($blog->blogTag as $blogTag){
             return Tag::find($blogTag->tag->tag_id);
        }
    }

    public function blogSearch($title){
        return Blog::where('title','like','%'.$title.'%')->get();
    }

    public function categoryIndex(){
        return Category::all();
    }

    public function categoryShow($id){
        return Category::find($id);
    }

    public function categorySearch($category_name){
        return Category::where('category_name','like','%'.$category_name.'%')->get();
    }

    public function categoryShowBlog($id){
        return Blog::where(['category_id' =>$id])->get();
    }

    public function tagIndex(){
        return Tag::all();
    }

    public function tagShow($id){
        return Tag::find($id);
    }

    public function tagSearch($tag_name){
        return Tag::where('tag_name','like','%'.$tag_name.'%')->get();
    }

    public function tagShowBlog($id){
        $blogTag = BlogTag::where(['tag_id' =>$id])->get();
        $blog = $blogTag->blog_id;
        return Blog::where(['blog_id' => $blog])->get();
    }
}
