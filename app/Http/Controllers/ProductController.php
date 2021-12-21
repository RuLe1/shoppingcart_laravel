<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Cart as ShoppingcartCart;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductController extends Controller
{
    public function show_product(){
        $products = Product::all();
        return view('/home',compact('products'));
    }
    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_available = 0;
            foreach($cart as $key=>$val){
                if($val['id'] == $data['cart_product_id']){
                    $is_available++;
                }
            }
            if($is_available == 0){
                $cart[] = array(
                    'session_id'=> $session_id,
                    'id'=> $data['cart_product_id'],
                    'product_name'=> $data['cart_product_name'],
                    'product_image'=> $data['cart_product_image'],
                    'product_qty'=> $data['cart_product_qty'],
                    'product_price'=> $data['cart_product_price'],
                    'product_color'=> $data['cart_product_color'],
                   );
                Session::put('cart',$cart);
            }
        }else{
           $cart[] = array(
            'session_id'=> $session_id,
            'product_name'=> $data['cart_product_name'],
            'id'=> $data['cart_product_id'],
            'product_image'=> $data['cart_product_image'],
            'product_price'=> $data['cart_product_price'],
            'product_qty'=> $data['cart_product_qty'],
            'product_color'=> $data['cart_product_color'],
           );
           Session::put('cart',$cart);
       } 
        Session::save();
    }
    public function update_cart_ajax(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart == true){
            foreach($data['cart_qty'] as $key => $qty){
               foreach($cart as $session => $val){
                   if($val['session_id'] == $key){
                       $cart[$session]['product_qty'] = $qty;
                   }
                   if($cart[$session]['product_qty'] == 0){
                    unset($cart[$session]);
                }
               }
            }
            Session::put('cart',$cart);
            return redirect()->route('home');
        }
    }
    public function delete_product($session_id){
        $cart = Session::get('cart');
        if($cart == true){
            foreach($cart as $key => $val){
                if($val['session_id'] == $session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return redirect()->route('home');
        }
    }
    // public function increaseQuantity($rowId){
    //     $product = Cart::get($rowId);
    //     $qty = $product->qty + 1;
    //     Cart::update($rowId,$qty);
    // }
    // public function decreaseQuantity($rowId){
    //     $product = Cart::get($rowId);
    //     $qty = $product->qty - 1;
    //     Cart::update($rowId,$qty);
    // }
    // public function del_all_product(){
    //     $cart = Session::get('cart');
    //     if($cart == true){
    //         Session::forget('cart');
    //     return redirect()->back()->with('status','Bạn đã xóa hết sản phẩm trong giỏ hàng');
    //     }
    // }
}
