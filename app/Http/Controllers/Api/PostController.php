<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Traits\HelperTrait;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use HelperTrait;

    public function index()
    {
        $post = Post::where('user_id', auth()->id())->get();
    
        return $this->responseJson(200,'Data Returned Successfully', $post, '');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
            'cover'=> 'required',
            'pinned'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=> 'Validation error',
                'errors'=>$validator->errors()
            ],400);
        }

        $newPost = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id'=> auth()->id(),
            'cover'=>$request->cover,
            'pinned'=>$request->pinned,
        ]);

        return $this->responseJson(200,'Data Created Successfully', $newPost, '');
    }

    
    public function show($id)
    {
        $post = Post::find($id);
        if(!$post)
        {
            return $this->responseJson(400,' No Data Found ','', '');
        }
        return $this->responseJson(200,'show this post', $post, '');
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
            'cover'=> 'required',
            'pinned'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=>'Validation error',
                'errors'=>$validator->errors()
            ],400);
        }
     
        $post = Post::find($id);
        if(!$post){
            return  $this->responseJson(400,'Data Not Found', '', '');
        }
        
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'user_id'=> auth()->id(),
            'cover'=>$request->cover,
            'pinned'=>$request->pinned,
            ]);

        return  $this->responseJson(200,'Post Updated Successfully','', '');

    }

    
    public function destroy($id)
    {
        $post = Post::where('user_id', auth()->id())->first();
        if (!$post)
        {
            return $this->responseJson(400,'Data Not Found', '', '');
        }
        $post->delete();
        return $this->responseJson(200,'Data Deleted Successfully', $post, '');
    }

    public function viewDeletedPost ()
    {
        $deletedPosts = Post::where('user_id', auth()->id())->onlyTrashed()->get();

        if (!$deletedPosts)
        {
            return $this->responseJson(400,' No Data Found ','', '');
        }
        
            return $this->responseJson(200,'Data Returned Successfully', $deletedPosts, '');
        
    }

    public function restore($id)
    {
        
        $restorePost = Post::withTrashed()->where('user_id', auth()->id())->where('id',$id)->first();
        if (!$restorePost)
        {
            return $this->responseJson(400,'Data Not Found', '', '');
        }
        $restorePost->restore();
        return $this->responseJson(200,'Data Returned Successfully','', '');

    }
}
