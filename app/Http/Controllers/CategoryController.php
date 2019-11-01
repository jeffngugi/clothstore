<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use App\Http\Requests\CategoryRequest;

class CategoryController extends APIController
{
    public function index(){
        $categories = Category::all();
        if($categories->count() < 1){
            return $this->responseSuccess('No any category. Kindly create new category');
        }
        if($categories->count() > 0){
            return $this->responseSuccess('Categoriesfound', $categories);
        }


    }


    public function store(CategoryRequest $request){

        try {
            $input= $request->all();
            $category =Category::create($input);
            if($category){
                $categories = Category::all();
                return $this->responseSuccess('Category successfully created',null);
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
       


    }

    public function show($id){
        try {
            $category = Category::find($id);
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
            return $this->responseResourceDeleted();
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }


}
