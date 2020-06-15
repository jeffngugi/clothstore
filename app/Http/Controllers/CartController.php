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
        return 'users cart';
    }

    public function addToCart(Request $request){
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
    }

    public function removeFromCart($itemId){
        return 'remover item from cart';
    }

    public function clearCart(){
        return 'clear cart;';
    }

}
