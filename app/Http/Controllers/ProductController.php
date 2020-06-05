<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Image as ImageModel;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Storage;
use Image;

class ProductController extends APIController
{
    public function index(){
        try {
            // $products = Product::all();
            $products = Product::with('images')->get();
            if($products->count() < 1){
                return $this->responseNotFound('No products found, check later');
            }
            if($products->count() > 0){
                return $this->responseSuccess('Success',$products );
            }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function store(Request $request){
        return 'null';
        $user = User::getLogged();
        $user_id = $user['id'];    
        // return $user_id;
        
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
                $product = array_merge($request->all(), ['user_id'=>$user_id, 'status'=>true]);
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
            // $product = Product::find($id);
            $product = Product::with('images')->find($id);
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
            // $product = Product::where('slug', $slug)->first();
            $product = Product::with('image')->where('slug', $slug)->get();
            if(!$product){
                return $this->responseNotFound('Product not found');
            }
            return $this->responseSuccess('success', $product);
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function category($id){
        // return $id;
        try {
            // $product = Product::where('category_id', $id)->get();
            $product = Product::with('image')->where('category_id', $id)->get();
            if($product->count()< 1){
                return $this->responseNotFound('Sorry, No products in this category');
            }
            return $this->responseSuccess('success', $product);
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function type($id){
        try {
            // $product = Product::where('type_id', $id)->get();
            $product = Product::with('image')->where('type_id', $id)->get();
            if($product->count()< 1){
                return $this->responseNotFound('Sorry, No products in this type');
            }
            return $this->responseSuccess('success', $product);
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function update(Request $request,$id){
        try {
            $product = Product::find($id);
        if(!$product){
            return $this->responseNotFound('product not found');
        }else{
            // return $request;
            $product->update($request->all());
            if($product){
                return $this->responseResourceUpdated();
            }
        }
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
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
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }


    public function upload(Request $request){
        // return $request;
        if(!$request->hasFile('files')){
            return 'No files was found';
        }
        $user = User::getLogged();
        $user_id = $user['id'];    
        
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'price'=>'required|integer',
                'specification'=>'string|min:10',
                'color'=>'required|min:3',
                'quantity'=>'required|integer',
                'type_id'=>'required|integer',
                'category_id'=>'required|integer',
                'files'=>'array',
                'files.*'=>'image|mimes:jpeg,png'
            ]);
           
            if($validator->fails()){
                return $this->responseUnprocessable($validator->errors());
            }
                $product = array_merge($request->all(), ['user_id'=>$user_id, 'status'=>true]);
                // return $product;
                $save = Product::create($product);
                $files= $request->file('files');
                // return $files;
                foreach($files as $photo){
                    $name = $photo->getClientOriginalName();
                    $filename = 'clothstore'. $name;
                    $image = Image::make($photo)->resize(720, 458);
                    
                    // Storage::put('/cloths/')
                  Storage::put("/cloths/{$filename}", (string) $image->encode());
                   
                 
                    ImageModel::create([
                        'product_id'=>$save->id,
                        'name'=>$filename
                    ]);

                }
                return $this->responseResourceCreated('Product create successfully');
            
            
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }






    }


    static function coupon(){
         $user = User::getLogged();
        return $user;
    }

    
}
