<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\APIController;
use App\Models\Role;

use Illuminate\Http\Request;

class RoleController extends APIController
{
    public function index(){
        try {
            $role = Role::all();
            if($role->count() < 1){
                return $this->responseNotFound('No any role was found');
            }
            if($role->count() > 0){
                return $this->responseSuccess('Success',$role );
            }
            
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function show($id){
        try {
            $role = Role::find($id);
            if($role){
                return $this->responseSuccess('Success',$role);
            }else{
                return $this->responseNotFound('Nothing was found');
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:3|max:255|unique:roles',
                'description'=>'string'
            ]);
            if($validator->fails()){
                return $this->responseUnprocessable($validator->errors());
            }
            $input = $request->all();
            $role = Role::create($input);
            if($role){
                return $this->responseResourceCreated();
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function update(Request $request, $id){
        try {
            $role = Role::find($id);
            if($role){
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255|unique:roles',
                ]);
                if($validator->fails()){
                    return $this->responseUnprocessable($validator->errors());
                }else{
                    $role->update($request->all());
                    if($role){
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
            $role = Role::find($id);
            if(!$role){
                return $this->responseNotFound('role not was found');
            }else{
                $del = $role->delete();
                if($del){
                    return $this->responseSuccess('Succesfully deleted', $role);
                }
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }
}
