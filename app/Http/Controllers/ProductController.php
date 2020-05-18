<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends APIController
{
    public function index(){
        return $this->coupon();
    }

    public function store(Request $request){
        $user = User::getLogged();
        // $user_id = $user->id;
        // return $user;
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'price'=>'required|integer',
                'specification'=>'string|min:10',
                'color'=>'required|min:3',
                'quantity'=>'required|integer',
                'type_id'=>'required|integer',
                'category_id'=>'required|integer',
            ]);
           
            if($validator->fails()){
                return $this->responseUnprocessable($validator->errors());
            }else{
                $product = new Product;
                dd($user->id);
                // return $user;

                // return $request;
                // $product = $request->all();
                // $product->user_id = 1;
                // return $product;
                // $input = $request->all();
                // $subcategory = SubCategory::create($input);
                // if($subcategory){
                //     return $this->responseResourceCreated('Subcategory create successfully');
                // }
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function show(){

    }

    public function update(){

    }

    public function destroy(){

    }


    static function coupon(){
         $user = User::getLogged();
        return $user;
    }

    
}
