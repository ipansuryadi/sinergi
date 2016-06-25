<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Brand;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ConfirmationRequest;
use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CartTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Order;
use App\Payment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class ProfileController extends Controller {


    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /* This page uses the Auth Middleware */
    public function __construct() {
        $this->middleware('auth');
        // Reference the main constructor.
        parent::__construct();
    }


    /**
     * Display Profile contents
     *
     * @return mixed
     */
    public function index() {

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $categories = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        // Get the currently authenticated user
        $username = \Auth::user();

        // Set user_id to the currently authenticated user ID
        $user_id = $username->id;

        // Select all from "Orders" where the user_id = the ID og the signed in user to get all their Orders
        $orders = Order::where('user_id', '=', $user_id)->get();
        $rand_brands = Brand::orderByRaw('RAND()')->take(6)->get();
        return view('profile.index', compact('categories', 'brands', 'search', 'cart_count', 'username', 'orders','rand_brands'));
    }

    public function profile(){
        $categories = $this->categoryAll();
        $brands = $this->brandsAll();
        $search = $this->search();
        $cart_count = $this->countProductsInCart();
        $username = \Auth::user();
        $user_id = $username->id;
        $address = \DB::table('address')
        ->where('user_id',$user_id)->get();
        $orders = Order::where('user_id', '=', $user_id)->get();
        $rand_brands = Brand::orderByRaw('RAND()')->take(6)->get();
        return view('profile.profile', compact('categories', 'brands', 'search', 'cart_count', 'username', 'orders','address','rand_brands'));
    }
    
    public function addNewAddress(){
        $categories = $this->categoryAll();
        $brands = $this->brandsAll();
        $search = $this->search();
        $cart_count = $this->countProductsInCart();
        $username = Auth::user();
        $provinsi = \DB::table('provinsi')->get();
        $rand_brands = Brand::orderByRaw('RAND()')->take(6)->get();
        return view('profile.add_address', compact('categories', 'brands', 'search', 'username', 'cart_count','provinsi','rand_brands'));
    }

    public function kabupaten(Request $request){
        $kabupaten = \DB::table('kabupaten')->where('provinsi_id',Input::get('provinsi'))->orderBy('kabupaten_name','asc')->get();
        $html = "<option value='' selected disable>Kabupaten</option>";
        foreach ($kabupaten as $value) {
            $html .= "<option value='".$value->id."'>".$value->kabupaten_name.".</option>";
        }
        return $html;
    }

    public function kecamatan(Request $request){
        $kecamatan = \DB::table('kecamatan')->where('kabupaten_id',Input::get('kabupaten'))->orderBy('kecamatan_name','asc')->get();
        $html = "<option value='' selected disable>Kecamatan</option>";
        foreach ($kecamatan as $value) {
            $html .= "<option value='".$value->id."'>".$value->kecamatan_name.".</option>";
        }
        return $html;
    }

    public function postNewAddress(AddressRequest $request){
        $username = \Auth::user();
        $user_id = $username->id;
        $provinsi_id = Input::get('provinsi');
        $kabupaten_id = Input::get('kabupaten');
        $kecamatan_id = Input::get('kecamatan');
        $provinsi = \DB::table('provinsi')->where('id',$provinsi_id)->first();
        $kabupaten = \DB::table('kabupaten')->where('id',$kabupaten_id)->first();
        $kecamatan = \DB::table('kecamatan')->where('id',$kecamatan_id)->first();
        $name = Input::get('name');
        $email = Input::get('email');
        $phone = Input::get('phone');
        $address = Input::get('address');
        $data = [
            'user_id'=>$user_id,
            'provinsi'=>$provinsi->provinsi_name,
            'kabupaten'=>$kabupaten->kabupaten_name,
            'kecamatan'=>$kecamatan->kecamatan_name,
            'location'=>$kecamatan->kecamatan_name.', '.$kabupaten->kabupaten_name,
            'name'=>$name,
            'email'=>$email,
            'phone'=>$phone,
            'address'=>$address,
        ];
        $save = \DB::table('address')->insert($data);
        if ($save) {
            //ipansuryadiflash()->success('Success', 'Address created successfully!');
        } else {
            //ipansuryadiflash()->error('Error', 'Cannot create address.');
        }
        return redirect()->route('profile');
    }

    public function postDeleteAddress(Request $request){
        // return var_dump(Input::all());
        $delete = \DB::table('address')->where('id', Input::get('address_id'))->update(['user_id'=>'0']);
        //ipansuryadiflash()->success('Success', 'Address deleted successfully!');
        return redirect()->route('profile');
    }

    public function paymentConfirmation($id){
        $categories = $this->categoryAll();
        $brands = $this->brandsAll();
        $search = $this->search();
        $cart_count = $this->countProductsInCart();
        $username = \Auth::user();
        $user_id = $username->id;
        $orders = Order::where('id', '=', $id)->get();
        $check_address = Order::where('id', '=', $id)->first();
        // return dd($orders);
        $banks = Bank::get();
        $rand_brands = Brand::orderByRaw('RAND()')->take(6)->get();
        return view('profile.confirmation', compact('categories', 'brands', 'search', 'cart_count', 'username', 'orders','banks','rand_brands'));
    }

    public function postPaymentConfirmation(ConfirmationRequest $request){
        if(Input::get('cod')){
            \DB::table('orders')->where('id',$request->input('order_id'))->update(['status'=>'cod']);
        }else{
            $payment = Payment::create([
                'order_id' => $request->input('order_id'),
                'bank_name' => $request->input('bank_name'),
                'account_name' => $request->input('account_name'),
                'account_no' => $request->input('account_no'),
                'bank_id' => $request->input('bank_id'),
                'amount' => $request->input('amount'),
                'status' => 'unverified',
                ]);
            $payment->save();      
            \DB::table('orders')->where('id',Input::get('order_id'))->update(['status'=>'waiting']);
        }
        return redirect()->route('order');
    }
}