<?php

namespace App\Http\Controllers;
use App\Http\Controllers\APIController;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SubCategoryController extends APIController
{
    public function index(){

        try {
            $subcategories = SubCategory::all();
            if($subcategories->count() < 1){
                return $this->responseNotFound('No sub-category was found');
            }else{
                return $this->responseSuccess('Successful',$subcategories);
            }

        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function store(Request $request){
       
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:sub_categories',
                'category_id'=>'required|integer'
            ]);
            if($validator->fails()){
                return $this->responseUnprocessable($validator->errors());
            }else{
                $input = $request->all();
                $subcategory = SubCategory::create($input);
                if($subcategory){
                    return $this->responseResourceCreated('Subcategory create successfully');
                }
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function show($id){
        try {
            $subcategory = SubCategory::find($id);
            if(!$subcategory){
                return $this->responseNotFound('Subcategory not found');
            }else{
                return $this->responseSuccess('Successful',$subcategory);
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
       
        }
    }

    public function update(Request $request,$id){
        try {
            $subcategory = SubCategory::find($id);
            if($subcategory){
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255|unique:types',
                ]);
                if($validator->fails()){
                    return $this->responseUnprocessable($validator->errors());
                }else{
                    $subcategory->update($request->all());
                    if($subcategory){
                        return $this->responseResourceUpdated();
                    }
                }
            }else{
                return $this->responseNotFound('`Subcategory ` not found');
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function destroy($id){
        try {
            $subcategory = SubCategory::find($id);
            if(!$subcategory){
                return $this->responseNotFound('Type not was found');
            }else{
                $del = $subcategory->delete();
                if($del){
                    return $this->responseSuccess('Succesfully deleted', $subcategory);
                }
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
}
}