<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;
use App\Http\Resources\PostsResource;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('role:administrator')->only(['listUsers', 'DeleteUser', 'AsignRole']);
    }

    public function listUsers(){
        $users = User::all();
        return UserResource::collection($users);
    }

    public function ListUserPosts($id){
        $user = User::findOrFail($id);
        $posts =  $user->posts;
        return PostsResource::collection($posts);
    }
    //functions i need to add to this controller : deleteUser, asignRole, 

    public function DeleteUser($id){
        $user = User::findOrFail($id);
        $user->delete();
        if($user){
            return response()->json([
                'message'=>'user Deleted successfully'
            ], 201);
        }
        return response()->json([
            'message'=>'user wasn\'t Deleted successfully'
        ], 501); 
    }

    public function AsignRole(Request $request, $userId){
        //
        $validatedData = $request->validate([
            'id' => 'required'
        ]);
        $role_id = $validatedData['id'];
        $user = User::find($userId);
        $role = Role::find($role_id);
        $user->syncRoles([$role]);

        if(!$user || !$role){
            return response()->json(['message' => 'user or role not found'], 404); 
        }
        return response()->json(['message' => 'Role assigned to user successfully'], 200);
    }
}
