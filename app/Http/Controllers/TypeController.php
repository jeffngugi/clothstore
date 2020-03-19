<?php

namespace App\Http\Controllers;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Type;
use App\Http\Requests\CategoryRequest;

class TypeController extends APIController
{
    public function index(){
        try {
            $type = Type::all();
            if($type->count() < 1){
                return $this->responseNotFound('No any type was found');
            }
            if($type->count() > 0){
                return $this->responseSuccess('Success',$type );
            }
            
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function store(Request $request){
      

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:types',
            ]);
            if($validator->fails()){
                return $this->responseUnprocessable($validator->errors());
            }
            $input = $request->all();
            $types = Type::create($input);
            if($types){
                return $this->responseResourceCreated();
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function show($id){
        try {
            $type = Type::find($id);
            if($type){
                return $this->responseSuccess('Success',$type);
            }else{
                return $this->responseNotFound('Nothing was found');
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function update(Request $request,$id){
        
        try {
            $type = Type::find($id);
            if($type){
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255|unique:types',
                ]);
                if($validator->fails()){
                    return $this->responseUnprocessable($validator->errors());
                }else{
                    $type->update($request->all());
                    if($type){
                        return $this->responseResourceUpdated();
                    }
                }
            }else{
                return $this->responseNotFound('`Type` not found');
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function destroy($id){
        try {
            $type = Type::find($id);
            if(!$type){
                return $this->responseNotFound('Type not was found');
            }else{
                $del = $type->delete();
                if($del){
                    return $this->responseSuccess('Succesfully deleted', $type);
                }
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }
}
