<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleResource;

class RolesController extends Controller
{
    //
    public function listRoles(){
        $roles = Role::all();
        return RoleResource::collection($roles);
    }
}
