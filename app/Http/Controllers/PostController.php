<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostsResource;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:moderator|administrator')->only(['AddPost', 'DeletePost', 'UpdatePost']);
    }

    //list all posts using the PostsResource
    public function ListAllposts(){
        $posts=Post::paginate(9);
        return response()->json($posts);
    }

    //get post by id
    public function GetPostById($id){
        $post = Post::find($id);
        return $post;
    }

    //creating a new post
    public function AddPost(Request $request){

        $validatedPostData = $request->validate([
            'post_title' => 'required',
            'post_body' => 'required',
            'post_image' => 'required',
            'category_id' => 'required',
        ]);

        $image_path = $request->file('post_image')->store('image', 'public');

        $createdPost = new Post();
        $createdPost->post_title = $validatedPostData['post_title'];
        $createdPost->post_body = $validatedPostData['post_body'];
        $createdPost->post_image = $image_path;
        $createdPost->category_id = $validatedPostData['category_id'];
        $createdPost->user_id = $request->user()->id;
        $createdPost->save();

        if ($request->has('tags')) {
            $tagNames = explode(',', $request['tags']);
            $tagIds = [];
    
            foreach ($tagNames as $tagName) {
                $tagName = trim($tagName);
    
                $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
    
                $tagIds[] = $tag->id;
            }
    
            $createdPost->tags()->attach($tagIds);
        }


        if(!$createdPost){
            return response()->json([
                'message'=>'Post wasn\'t created successfully',
            ], 401);
        }

        return response()->json([
            'message'=>'Post was created successfully',
        ], 201);
    }

    public function DeletePost($id){
        $post = Post::findOrFail($id);
        $post->delete();
        if($post){
            return response()->json([
                'message'=>'Post was deleted successfully',
            ], 201);
        }
        return response()->json([
            'message'=>'Post wasn\'t deleted successfully',
        ], 500);
    }

    public function UpdatePost(Request $request, $id){
    
        $int_id = (int) $id;
        $post = Post::find($int_id);
        // $validatedPostData = $request->validate([
        //     'post_title' => 'required',
        //     'post_body' => 'required',
        //     'post_image' => 'required',
        //     'category_id' => 'required',
        // ]);
        $post->post_title = $request['post_title'];
        $post->post_body = $request['post_body'];
        $post->category_id = $request['category_id'];
        $post->user_id = $request->user()->id;
        //$post->post_image = $request['post_image'];

        $post->save();

        if($request->has('tags')){
            $tagNames = explode(',',$request['tags']); //transforming the data from string to array
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                $tagName = trim($tagName); //trim method trims white spaces from the end and beginning of a string
                $issuedTag = Tag::firstOrCreate(['tag_name' =>$tagName]);
                $tagIds[] = $issuedTag->id;
            }
            $post->tags()->attach($tagIds);
        }

    }
}
