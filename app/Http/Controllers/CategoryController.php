<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\APIController;
use App\Http\Requests\CategoryRequest;

class CategoryController extends APIController
{
    public function index(){

        $categories = Category::with('subcategories')->get();
        // $categories = Category::all();
     
        if($categories->count() < 1){
            
            return $this->responseNotFound('No any category. Kindly create new category');
        }
        if($categories->count() > 0){
            return $this->responseSuccess('Categories found', $categories);
        }


    }


    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories',
            ]);
            if($validator->fails()){
                return $this->responseUnprocessable($validator->errors());
            }
            $input = $request->all();
            $category = Category::create($input);
            if($category){
                return $this->responseResourceCreated();
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
       


    }

    public function show($id){
        try {
            // $category = Category::find($id);
            $category = Category::with('subcategories')->find($id);
        if(!$category){
            return $this->responseNotFound('Category not found');
        }else{
            return $this->responseSuccess('Success', $category);
        }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
        
    }


    public function update(Request $request,$id){
        try {
            $category = Category::find($id);
        if(!$category){
            return $this->responseNotFound('Category not found');
        }else{
            $category->update($request->all());
            if($category){
                return $this->responseResourceUpdated();
            }
        }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }

        

    }

    public function destroy($id){
        try {
            $category = Category::find($id);
            if(!$category){
                return $this->responseNotFound('Category not found');
            } 
            $category->delete();
            return $this->responseResourceDeleted('category succesfully deleted');
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }


}
