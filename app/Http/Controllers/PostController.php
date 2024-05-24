<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatagoeryRequest;
use App\Models\Post;
use App\Models\PostTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Str;

class PostController extends ApiController
{
    public function PostStore(CatagoeryRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "tag_id "    => "array",

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = Auth::check() ? Auth::id() : null;
        $imageArr = array();

        if (isset($request->tag_id)) {
            $imageArr = $request->tag_id;
            unset($request->tag_id);
        }

        $post = new Post();
        $post->user_id = $userId;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->slug = Str::slug($request->title);
        $post->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $post->image = 'images/' . $name;
        }

        $post->save();

        if ($request->has('tag_id')) {
            $tag_ids = is_array($request->input('tag_id')) ? $request->input('tag_id') : [$request->input('tag_id')];
            $post->tags()->sync($tag_ids);
        }

        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }

    public function getPost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        return response()->json(['post' => $post]);
    }
    public function getallPost()
    {
        $post = Post::get();
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }else{
           
            foreach ($post as $key => $value) {
                $value->category_name = $value->category->name;
                if($value->image){
                    $value->image = asset('public/images/' . $value->image);
                }else{
                    $value->image = asset('public/images/default.jpg');
                }
                
               
                if($value->tags->count()){
                    foreach ($value->tags as $key => $tag) {

                        //dd($tag->name);
                        $tag->makeHidden('slug');
                        $tag->makeHidden('status');
                        $tag->makeHidden('status');
                        $tag->makeHidden('pivot');
                       // $value->makeHidden('deleted_at');
                        $tag->makeHidden('created_at');
                        $tag->makeHidden('updated_at');
                    }
    
                }
                # code...
                $value->makeHidden('category');
              
                $value->makeHidden('deleted_at');
                $value->makeHidden('created_at');
                $value->makeHidden('updated_at');
            }
        }
        return $this->respondWithData($post);
       
    }

    

    public function updatePost(Request $request,$id)
    {
     
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tag_id' => 'array',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $userId = Auth::check() ? Auth::id() : null;
        $imageArr = array();
    
        if (isset($request->tag_id)) {
            $imageArr = $request->tag_id;
            unset($request->tag_id);
        }
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }
    
        $post->user_id = $userId;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->slug = Str::slug($request->title);
        $post->category_id = $request->category_id;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $post->image = 'images/' . $name;
        }
    
        $post->save();
    
        if ($request->has('tag_id')) {
            $tag_ids = is_array($request->input('tag_id')) ? $request->input('tag_id') : [$request->input('tag_id')];
            $post->tags()->sync($tag_ids);
        }
    
        return response()->json(['message' => 'Post updated successfully', 'post' => $post]);
    }
    

    public function DeletePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        $post->delete();
        return response()->json(['message' => 'Post  deleted successfully']);
    }
}
