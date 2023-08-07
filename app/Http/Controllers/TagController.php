<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagsResource;
use App\Http\Resources\PostsResource;

class TagController extends Controller
{
    //
    public function __construct(){
        $this->middleware('role:administrator|moderator')->except(['ListTagPosts']);
    }

    public function ListTags(){
        $tags = Tag::all();
        return TagsResource::collection($tags);
    }

    public function AddTag(Request $request){
        $validatedData = $request->validate([
            'tag_name' => 'required',
            'tag_description' => 'required'
        ]);

        $createdTag = Tag::create($validatedData);
        if(!$createdTag){
            return response()->json([
                'message' => 'tag wasn\'t created successfully'
            ], 501);
        }
        return response()->json([
            'message' => 'tag wasn created successfully'
        ], 201);
    }
    public function UpdateTag(Request $request, $id){
        $validatedData = $request->validate([
            'tag_name' => 'required',
            'tag_description' => 'required'
        ]);

        $tag = Tag::find($id);
        $updated = $tag->update($validatedData);
        if(!$updated){
            return response()->json([
                'message' => 'tag wasn\'t updated successfully'
            ], 501);
        }
        return response()->json([
            'message' => 'tag wasn updated successfully'
        ], 201);
    }
    public function DeleteTag($id){
        $tag = Tag::find($id);

        $deleted = $tag->delete();

        if($deleted){
            return response()->json([
                'message' => 'tag deleted successfully'
            ], 201);
        }
        return response()->json([
            'message' => 'tag wasn\'t deleted successfully'
        ], 201);
    }

    public function ListTagPosts($id){
        $tag = Tag::findOrFail($id);
        $posts = $tag->posts;
        return PostsResource::collection($posts);
    }
}
