<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\APIController;

class CouponController extends APIController
{
    public function index(){
        try {
            $coupon = Coupon::all();
            if($coupon->count() < 1){
                return $this->responseNotFound('No any type was found');
            }
            if($coupon->count() > 0){
                return $this->responseSuccess('Success',$coupon );
            }
            
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function store(Request $request){
      

        try {
            $validator = Validator::make($request->all(), [
                'type' => ['required', 'regex:/percentage|fixed/'],
                'code' => 'required|string|max:255|unique:coupons',
                'value'=> 'required'
            ]);
            if($validator->fails()){
                return $this->responseUnprocessable($validator->errors());
            }else{
                $input = $request->all();
                $coupons = Coupon::create($input);
                if($coupons){
                    return $this->responseResourceCreated();
                }
            }
           
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function show($id){
        try {
            $coupon = Coupon::find($id);
            if($coupon){
                return $this->responseSuccess('Success',$coupon);
            }else{
                return $this->responseNotFound('Nothing was found');
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function update(Request $request,$id){
        
        try {
            $coupon = Coupon::find($id);
            if($coupon){
                $validator = Validator::make($request->all(), [
                    'type' => ['required', 'regex:/percentage|fixed/'],
                    'code' => 'required|string|max:255|unique:coupons',
                    'value'=> 'required'
                ]);
                if($validator->fails()){
                    return $this->responseUnprocessable($validator->errors());
                }else{
                    $coupon->update($request->all());
                    if($coupon){
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
            $coupon = Coupon::find($id);
            if(!$coupon){
                return $this->responseNotFound('Type not was found');
            }else{
                $del = $coupon->delete();
                if($del){
                    return $this->responseSuccess('Succesfully deleted', $coupon);
                }
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }   
}
