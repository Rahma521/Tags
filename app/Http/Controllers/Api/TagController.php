<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Traits\HelperTrait;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    use HelperTrait;


    public function index()
    {
        $tags = Tag::get();
        return $this->responseJson(200,'Data Returned Successfully', $tags, '');
        // dd($tags);
    }
    
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=>'dublicated tag',
                'errors'=>$validator->errors()
            ],400);
        }

        $newTag=Tag::create(['name' => $request->name]);
        return $this->responseJson(200,'Data Created Successfully', $newTag, '');
    }
    
    public function update(Request $request, Tag $id)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=>'dublicated tag',
                'errors'=>$validator->errors()
            ],400);
        }
     
        $tag = Tag::find($id);
        if(!$tag)
        {
    
            return  $this->responseJson(400,'Tag Not Found', '', '');
        }
        
        $tag->update(['name' => $request->name]);
        return $this->responseJson(200,'Data Updated Successfully', $tag, '');

    }

    
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if (!$tag)
        {
            return  $this->responseJson(400,'Tag Not Found', '', '');
        }
        $tag->delete();
        if ($tag)
        {  
            return $this->responseJson(200,'Data Deleted Successfully', $tag, '');

        }
    }
}
