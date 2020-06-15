<?php

namespace App\Http\Controllers;
use App\Models\User; 
namespace App\Http\Controllers;
use App\Http\Controllers\APIController;
use App\Models\Wishlist;
use App\Models\Product;


use Illuminate\Http\Request;

class WishlistController extends APIController
{
   
    public function index(){
        try {
            $wishlists = Wishlist::all();
            if($wishlists->count() < 1){
                return $this->responseNotFound('No wishlist was found');
            }else{
                return $this->responseSuccess('Successful',$wishlists);
            }

        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function store(Request $request){
        return 'null';
        $user = User::getLogged();
        $user_id = $user['id'];  
        return $user_id;
    }
    
    public function createWish($productId){
        $user = User::getLogged();
        $user_id = $user['id'];
        try {
            $wished = Wishlist::where('product_id', $productId)->where('user_id', $user_id)->first();
            if($wished){
                return $this->responseSuccess('Sorry, product already exist in wishlist',$wished);
            }
            $wish = new Wishlist;
            $product = Product::find($productId);
            if(!$product){
                return $this->responseNotFound('Product not found');
            }
            $wish->user_id = $user_id;
            $wish->product_id = $productId;
            $save = $wish->save();
            if($save){
                return $this->responseResourceCreated('Wish succesfully created');
            }
            // $newwish = array_merge()
            return $wish;

        }catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function show($id){
        $user = User::getLogged();
        $user_id = $user['id'];
        // $user_id = 2;
        try {
            $wishlist = Wishlist::find($id);
            if(!$wishlist){
                return $this->responseSuccess('Wishlist not found, try adding new',null);
            }
            $userwishlist = Wishlist::find($id)->where('user_id', $user_id)->first();
            if(!$userwishlist){
                return $this->responseUnauthorized();
            }
            return $this->responseSuccess('Success', $wishlist);
            // return $wishlist;
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function userWishlist(){
        $user = User::getLogged();
        $user_id = $user['id'];
        try {
            $wishlists = Wishlist::where('user_id', $user_id)->get();
            return $this->responseSuccess('Successful',$wishlists);
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }

    public function update($id){
        return 'null';
    }

    public function destroy($id){
        $user = User::getLogged();
        $user_id = $user['id'];
        // $user_id = 2;
        try {
            $wishlist = Wishlist::find($id);
            if(!$wishlist){
                return $this->responseSuccess('Wishlist not found, try adding new',null);
            }
            $userwishlist = Wishlist::find($id)->where('user_id', $user_id)->first();
            if(!$userwishlist){
                return $this->responseUnauthorized();
            }
            // return 'about to delete wishlist';
            $del = $wishlist->delete();
            if($del){
                return $this->responseSuccess('Successfully deleted', null);
            }
            // return $wishlist;
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
    }
}
