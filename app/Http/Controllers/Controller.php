<?php

namespace App\Http\Controllers;

use App\Category;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;

    /**
     * Make a constructor to initialize Auth check.
     */
    public function __construct() {
        // set user = to the currently authenticated user.
        $this->user = Auth::user();
        view()->share('signedIn', Auth::check());
        view()->share('user', $this->user);
        view()->share('super', $this->user);
        $product_list_search = DB::table('products')
            ->leftJoin('categories','products.cat_id','=','categories.id')
            ->leftJoin('brands','products.brand_id','=','brands.id')
            ->select(DB::raw("CONCAT(categories.category,'__',brands.brand_name,'__',products.product_name) AS product_list"))
            ->get();
        view()->share('product_list_search', $product_list_search);
        $category_search = Category::whereNull('parent_id')->get();
        view()->share('category_search',$category_search);
    }
}
