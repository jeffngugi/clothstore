<?php

namespace App\Http\Controllers;
use App\Models\User; 
use App\Models\Cart; 
use App\Models\CartItem; 
use App\Models\Product;
use App\Http\Controllers\APIController;
use Illuminate\Http\Request;

class CartController extends APIController
{
    public function mycart(){
        try {
            $user = User::getLogged();
        $user_id = $user['id'];
        $cart = Cart::where('user_id',$user_id)->first();
        // return $cart;
        $myCart = CartItem::with('product')->where('cart_id',  $cart->id)->get();
        return $this->responseSuccess('Success', $myCart);
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
        
    }

    public function addToCart(Request $request){
        try {
            $user = User::getLogged();
            $user_id = $user['id'];
            //check if user have a cart
            $cart = Cart::where('user_id', $user_id)->first();
            if(!$cart){//create cart if he don't have
                $newcart = ['user_id'=>$user_id];
                $save = Cart::create($newcart);
                if(!$save){
                            return $this->responseUnprocessable('Something went wrong');
                        }
                }
                //check if product exists
                $product = Product::find($request->product_id);
                if(!$product){
                    return $this->responseNotFound('Product not found');
                }
                $cartItem = ['cart_id'=>$cart->id,'product_id'=>$product->id, 'quantity'=>$request->quantity];
                //check if product exists in users cart
                $checkCart =CartItem::where('product_id',$product->id)->where('cart_id', $cart->id)->first();
            if($checkCart){
                $checkCart->update($request->all());//update product if it exists
                return $this->responseSuccess('Cart updated', $checkCart);
            } 
            //if product do not exist in users cart, create one.
                $save = CartItem::create($cartItem);
                if($save){
                    return $this->responseSuccess('Product added to cart', $save);
                }
                } catch (Exception $e) {
                    return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
        
    }

    public function removeFromCart($itemId){
        try {
            $user = User::getLogged();
            $user_id = $user['id'];
            // $user_id = 2;
            $item = CartItem::find($itemId);
            if($item){
                // return $item->cart_id;
                $cart = Cart::where('id',$item->cart_id)->where('user_id', $user_id)->first();
                if(!$cart){
                    return $this->responseUnauthorized('You are not authorised to perform this');
                }
                $del = $item->delete();
                if($del){
                    return $this->responseSuccess('Succesfully removed', null);
                }
                // return $user_id;
            }else{
                return $this->responseNotFound('item no found');
            }
            return $item->cart_id;
        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
       
    }

    public function clearCart(){
        try {
            $user = User::getLogged();
            $user_id = $user['id'];
            // $user_id = 2;
            // return $user_id;
            $cart = Cart::where('user_id', $user_id)->first();
            if(!$cart){
                return $this->responseNotFound('No cart for this user');
            }
            $item = CartItem::where('cart_id', $cart->id);
            // return $item->get();
            if($item->get()->count() < 1){
                return $this->responseSuccess('Cart is empty', null);
            }
           $del = $item->delete();
           if($del){
               return $this->responseResourceDeleted('Cart cleared succesfully');
           }
            // return $item->get();

        } catch (Exception $e) {
            return Response::json([  'errors'=> [ ['message' => $e->getMessage()] ] ]);
        }
        
    }

}
