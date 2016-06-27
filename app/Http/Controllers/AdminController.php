<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderDeliveryRequest;
use App\Http\Traits\CartTrait;
use App\Order;
use App\Payment;
use App\Product;
use App\Slideshow;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller {

    use CartTrait;


    /**
     * Show the Admin Dashboard
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        
        // return redirect()->route('admin.pages.order');

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();
        
        // Get all the orders in DB
        $orders = Order::all();

        // Get the grand total of all totals in orders table
        $count_total = Order::sum('total');

        // Get all the users in DB
        $users = User::all();
        
        
        // Get all the carts in DB
        $carts = Cart::all();

        // Get all the carts in DB
        $products = Product::all();
        
        // Select all from Products where the Product Quantity = 0
        $product_quantity = Product::where('product_qty', '<=', 1)->get();

        return view('admin.pages.index', compact('cart_count', 'orders', 'users', 'carts', 'count_total', 'products', 'product_quantity'));
    }
    
    public function user(){
        $cart_count = $this->countProductsInCart();
        if (Auth::user()->id == 1) {
            $users = User::where('id','<>',1)->get();
        }else{
            $users = User::where('id','<>',1)->where('admin','<>',1)->get();
        }
        $count = $users->count();
        return view('admin.pages.user',compact('cart_count','users', 'count'));
    }
    
    /**
     * Delete a user
     * 
     * @param $id
     * @return mixed
     */
    public function delete($id) {

        // Find the product id and delete it from DB.
        $user = User::findOrFail($id);

        if (Auth::user()->id == 2) {
            // If user is a test user (id = 2),display message saying you cant delete if your a test user
            //ipansuryadiflash()->error('Error', 'Cannot delete users because you are signed in as a test user.');
        } elseif ($user->admin == 1) {
            // If user is a admin, don't delete the user, else delete a user
            //ipansuryadiflash()->error('Error', 'Cannot delete Admin.');
        } else {
            $user->delete();
        }

        // Then redirect back.
        return redirect()->back();
    }


    /** Delete a cart session
     * 
     * @param $id
     * @return mixed
     */
    public function deleteCart($id) {
        // Find the product id and delete it from DB.
        $cart = Cart::findOrFail($id);

        if (Auth::user()->id == 2) {
            // If user is a test user (id = 2),display message saying you cant delete if your a test user
            //ipansuryadiflash()->error('Error', 'Cannot delete cart because you are signed in as a test user.');
        } else {
            $cart->delete();
        }

        // Then redirect back.
        return redirect()->back();
    }


    /**
     * Update the Product Quantity if empty for Admin dashboard
     * 
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request) {

        // Validate email and password.
        $this->validate($request, [
            'product_qty' => 'required|max:2|min:1',
        ]);

        // Set the $qty to the quantity inserted
        $qty = Input::get('product_qty');

        // Set $product_id to the hidden product input field in the update cart from
        $product_id = Input::get('product');

        // Find the ID of the products in the Cart
        $product = Product::find($product_id);

        $product_qty = Product::where('id', '=', $product_id);

        if (Auth::user()->id == 2) {
            // If user is a test user (id = 2),display message saying you cant delete if your a test user
            //ipansuryadiflash()->error('Error', 'Cannot update product quantity because you are signed in as a test user.');
        } else {
            // Update your product qty
            $product_qty->update(array(
                'product_qty' => $qty
            ));
        }


        return redirect()->back();
        
    }

    public function order(){
        $cart_count = $this->countProductsInCart();
        
        $now = Carbon::now();
        $order_expired = Order::where('created_at','<', $now->subDays(1))->where('status','unpaid')->get();
        if ($order_expired->count() != 0) {
            foreach ($order_expired as $value) {
                foreach ($value->orderItems as $element) {
                    $product = Product::find($element->pivot->product_id);
                    $product->increment('product_qty', $element->pivot->qty);
                    $product->decrement('buy', $element->pivot->qty);
                    // DB::table('order_product')->where('order_id',$value->id)->delete();
                }
            }
            $cancel = Order::find($order_expired[0]->id);
            $cancel->update(['status'=>'canceled:no-payment']);
        }
        
        $orders = Order::orderBy('created_at','desc')->get();
        $count = Order::count();
        $status = Order::distinct()->select('status')->get();
        return view('admin.pages.order', compact('cart_count', 'orders', 'count', 'status'));
    }

    public function status($status){
        $cart_count = $this->countProductsInCart();
        $orders = Order::where('status',$status)->get();
        $count = Order::count();
        $status = Order::distinct()->select('status')->get();
        return view('admin.pages.order', compact('cart_count', 'orders', 'count', 'status'));
    }

    public function orderVerify($id){
        $cart_count = $this->countProductsInCart();
        $payment = Payment::where('order_id',$id)->get();
        return view('admin.pages.verify', compact('cart_count','payment'));
    }

    public function postOrderVerify(Request $request){
        $payment = Payment::where('id',Input::get('payment_id'))->update(['status'=>'verified']);
        $order = Order::where('id',Input::get('order_id'))->update(['status'=>'paid - waiting for delivery']);
        //ipansuryadiflash()->success('Success', 'Order verification success...');
        return redirect()->route('admin.pages.order');
    }

    public function orderDelivery($id){
        $cart_count = $this->countProductsInCart();
        $orders = Order::where('id',$id)->get();
        return view('admin.pages.delivery', compact('cart_count', 'orders'));
    }

    public function postOrderDelivery(OrderDeliveryRequest $request){
        // order delivery request tambah tanggal, pengupdate
        $data = [
            'ongkir_real'=>$request->input('ongkir_real'),
            'kurir'=>$request->input('kurir'),
            'no_resi'=>$request->input('no_resi'),
            'delivery_date'=>xformatDate($request->input('delivery_date')),
            'status'=>'on delivery',
            'modified_by'=>Auth::user()->username
        ];
        $order = Order::where('id',Input::get('order_id'))->update($data);
        //ipansuryadiflash()->success('Success', 'Order delivery success...');
        return redirect()->route('admin.pages.order');
    }

    public function finishTransaction(Request $request){
        $order = Order::where('id',Input::get('order_id'))->update(['status'=>'finished', 'modified_by'=>Auth::user()->username]);
        //ipansuryadiflash()->success('Success', 'Order finished...');
        return redirect()->route('admin.pages.order');
    }

    public function changeRole(Request $request){
        // return var_dump($request->all());
        $user = User::find($request->input('id'));
        $user->update(['admin'=>$request->input('admin')]);
        return redirect()->back();
    }

    public function cancelOrder(Request $request){
        $cancel = Order::find($request->input('id'));
        foreach ($cancel->get() as $value) {
            foreach ($value->orderItems as $element) {
                $product = Product::find($element->pivot->product_id);
                $product->increment('product_qty', $element->pivot->qty);
                $product->decrement('buy', $element->pivot->qty);
            }
        }
        $cancel->update(['status'=>'canceled:by-'.Auth::user()->username]);
        return redirect()->back();
    }
}