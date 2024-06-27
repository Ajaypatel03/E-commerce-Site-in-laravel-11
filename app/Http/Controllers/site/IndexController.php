<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function openHomePage(){
        // session()->flush();
        $products = Product::all();
        return view('site.index',compact('products'));
    }

    public function openProductDetail(){

        return view('site.productdetail');
    }

    public function openCartPage(){

        return view('site.cart');
    }

    public function openCheckoutPage(){

        return view('site.checkout');
    }

    public function AddProductIntoCart(Request $request){

        $product_id = $request->product_id;
        
        $product = Product::find($product_id);

        if( !$product ) {
            
            return response()->json([
                'error'=>'Unable To Find This Product'
            ],404);
        }

        $cart = session()->get('cart');

        $productId = $product->id;
        if(!$cart){         
            $cart = [
                $productId => [
                'name'=>$product->name,
                'quantity'=> 1 ,
                'price'=>$product->price,
                'image'=>$product->gallery ? $product->gallery->image : ''
                ]
            ];

            session()->put('cart',$cart);
        }

        if(isset($cart[$productId])){

            $cart[$productId]['quantity'] ++ ;
            session()->put('cart',$cart);
        }

        else{
           $cart[$productId]= [
                    'name'=>$product->name,
                    'quantity'=> 1 ,
                    'price'=>$product->price,
                    'image'=>$product->gallery ? $product->gallery->image : ''
           ];
            session()->put('cart',$cart);
        }        
        
        return response()->json([
            'products'=>$cart,
        ],201);
        
    }

    public function calculateCartItems(){

        $cart = session()->get('cart');
        $cartTotalItems = count($cart);

        return response()->json([
            'cart_total_items'=> $cartTotalItems
        ],201);
    }
}