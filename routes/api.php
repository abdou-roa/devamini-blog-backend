<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register',[AuthController::class,'register'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function(){
    //users management routes
    Route::get('/users', [UserController::class, 'listUsers']);
    Route::delete('/delete/user/{id}', [UserController::class, 'DeleteUser']);
    Route::post('/asign/role/{userId}', [Usercontroller::class, 'AsignRole']);
    // Route::put('update/user/{id}', [UserController::class, '']); 
    //posts management routes
    Route::post('/add/post', [PostController::class, 'AddPost']);
    Route::delete('/delete/post/{id}', [PostController::class, 'DeletePost']);
    Route::put('/update/post/{id}', [PostController::class, 'UpdatePost']);
    //categories management routes
    Route::post('/add/category', [CategoryController::class, 'AddCategory']);
    Route::put('/update/catedory/{id}', [CategoryController::class, 'EditCategory']);
    Route::delete('/delete/category/{id}', [CategoryController::class, 'DeleteCategory']);
    //tags management routes
    Route::get('/list/tags',[TagController::class, 'ListTags']);
    Route::post('/add/tag', [TagController::class, 'AddTag']);
    Route::put('/update/tag/{id}', [TagController::class, 'UpdateTag']);
    Route::delete('/delete/tag/{id}', [TagController::class, 'DeleteTag']);
});

Route::get('/posts', [PostController::class, 'ListAllposts']);
Route::get('/user/{id}/posts', [UserController::class, 'ListUserPosts']);
Route::get('/categories', [CategoryController::class, 'ListCategories']);
Route::get('/posts/tag/{id}', [TagController::class, 'ListTagPosts']);