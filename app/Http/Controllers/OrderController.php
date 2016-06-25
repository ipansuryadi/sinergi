<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CartTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Order;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Stripe\Stripe;
use Validator;


class OrderController extends Controller {

    
    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /**
     * Show products in Order view
     * 
     * @return mixed
     */
    public function index() {
        $search = $this->search();
        $categories = $this->categoryAll();
        $brands = $this->BrandsAll();
        $cart_count = $this->countProductsInCart();
        $user_id = Auth::user()->id;
        $check_cart = Cart::with('products')->where('user_id', '=', $user_id)->count();
        $count = Cart::where('user_id', '=', $user_id)->count();
        if (!$check_cart) {
            return redirect()->route('cart');
        }
        $cart_products = Cart::with('products')->where('user_id', '=', $user_id)->get();
        $cart_total = Cart::with('products')->where('user_id', '=', $user_id)->sum('total');
        $weight_total = Cart::with('products')->where('user_id', '=', $user_id)->sum('weight');
        $address = \DB::table('address')
        ->join('shipping','address.location','=','shipping.location')
        ->where('user_id',$user_id)
        ->select('address.id','address.name','address.email', 'address.phone', 'address.address', 'shipping.tarif')
        ->get();
        $rand_brands = Brand::orderByRaw('RAND()')->take(6)->get();
        return view('cart.checkout', compact('search', 'categories', 'brands', 'cart_count', 'count', 'address','rand_brands'))
            ->with('cart_products', $cart_products)
            ->with('cart_total', $cart_total)
            ->with('weight_total', $weight_total);
    }


    /**
     * Make the order when user enters all credentials
     * 
     * @param Request $request
     * @return mixed
     */
    public function postOrder(Request $request) {
        $address_tarif = explode('|', Input::get('address_id'));
        $address_id = $address_tarif[0];
        $total_ongkir = $address_tarif[1];
        $user_id = Auth::user()->id;
        $cart_products = Cart::with('products')->where('user_id', '=', $user_id)->get();
        $cart_total = Cart::with('products')->where('user_id', '=', $user_id)->sum('total');
        $charge_amount = number_format($cart_total, 2) * 100;
        $hariini = Carbon::today()->toDateTimeString();
        $jml = Order::where('created_at','>',$hariini)->count();
        $tgl = date('Ymd');
        $urutan = str_pad($jml+1,5,"0",STR_PAD_LEFT);
        $order = Order::create (
            array(
                'kode_transaksi' => $tgl.$urutan,
                'user_id'    => $user_id,
                'address_id'    => $address_id,
                'total_ongkir' => $total_ongkir,
                'total' => $cart_total+$total_ongkir,
                'status'    => 'unpaid'
            ));
        foreach ($cart_products as $order_products) {
            $order->orderItems()->attach($order_products->product_id, array(
                'qty'    => $order_products->qty,
                'price'  => $order_products->products->price,
                'reduced_price'  => $order_products->products->reduced_price,
                'total'  => $order_products->products->price * $order_products->qty,
                'total_reduced'  => $order_products->products->reduced_price * $order_products->qty,
            ));
            \DB::table('products')->where('id',$order_products->product_id)->decrement('product_qty', $order_products->qty);
            \DB::table('products')->where('id',$order_products->product_id)->increment('buy', $order_products->qty);
        }
        Cart::where('user_id', '=', $user_id)->delete();
        return redirect()->route('order');
    }
}