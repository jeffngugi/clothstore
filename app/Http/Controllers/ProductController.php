<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
class ProductController extends APIController
{
    public function index(){
        // return 'jeff ngugi';
        try {
            $categories = Product::all();
            if($categories->count() < 1){
                return $this->responseNotFound('No products found, check later');
            }
            if($categories->count() > 0){
                return $this->responseSuccess('Success',$categories );
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function store(Request $request){
        $user = User::getLogged();
        // var_dump($user);
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
            }
            
                // to do get slug
                $product = array_merge($request->all(), ['user_id'=>'1', 'status'=>true]);
                // return $this->responseSuccess('dsdsd', $product);
                // $input = $request->all();
                $save = Product::create($product);
                if($save){
                    return $this->responseResourceCreated('Product create successfully');
                }
            
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function show($id){
        try {
            $product = Product::find($id);
            if(!$product){
                return $this->responseNotFound('Product not found');
            }
            return $this->responseSuccess('success', $product);

        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function slug($slug){
        // return $slug;
        try {
            $product = Product::where('slug', $slug)->first();
            if(!$product){
                return $this->responseNotFound('Product not found');
            }
            return $this->responseSuccess('success', $product);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function category($id){
        // return $id;
        try {
            $product = Product::where('category_id', $id)->get();

            if($product->count()< 1){
                return $this->responseNotFound('Sorry, No products in this category');
            }
            return $this->responseSuccess('success', $product);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function type($id){
        // return $id;
        try {
            $product = Product::where('type_id', $id)->get();

            if($product->count()< 1){
                return $this->responseNotFound('Sorry, No products in this type');
            }
            return $this->responseSuccess('success', $product);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function update(Request $request,$id){
        return $id;
    }

    public function destroy($id){
        try {
            $product = Product::find($id);
            if(!$product){
                return $this->responseNotFound('Product not found');
            }else{
                $del = $product->delete();
                if($del){
                    return $this->responseSuccess('Succesfully deleted', $product);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    static function coupon(){
         $user = User::getLogged();
        return $user;
    }

    
}
