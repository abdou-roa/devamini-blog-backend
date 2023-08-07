<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('role:administrator|moderator')->except(['ListCategories']);
    }

    public function ListCategories(){
        //
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    public function AddCategory(Request $request){
        $newCategory = new Category();
        $validatedData = $request->validate([
            'category_name' => 'required',
            'category_description' => 'required'
        ]);
        $newCategory->category_name = $validatedData['category_name'];
        $newCategory->category_description = $validatedData['category_description'];

        $newCategory->save();

        return $newCategory;
    }

    public function EditCategory(Request $request, $id){
        //
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'category_name' => 'required',
            'category_description' => 'required'
        ]);
        $category->category_name = $validatedData['category_name'];
        $category->category_description = $validatedData['category_description'];

        $category->save();

        if($category){
            return response()->json([
                'message'=>'Category was edited successfully',
                ], 201);
        }
        return response()->json([
            'message'=>'Category wasn\'t edited successfully',
        ]);

    }

    public function DeleteCategory($id){
        //
        $category = Category::findOrFail($id);
        $category->delete();
        if($category){
            return response()->json([
                'message'=>'Category was deleted successfully',
                ], 201);
        }
        return response()->json([
            'message'=>'Category wasn\'t deleted successfully',
        ], 501);
    }

    //functions i need to add to this controller: editCategory, deleteCategory, 
}
