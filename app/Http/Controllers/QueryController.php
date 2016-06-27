<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\CartTrait;


class QueryController extends Controller {

    use BrandAllTrait, CategoryTrait, CartTrait;


    /**
     * Search for items in our e-commerce store
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search() {
        // return dd(Input::all());
        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $categories = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->brandsAll();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();

        // Gets the query string from our form submission
        $query = Input::get('search');
        // $separate = explode('__',$query);
        // if (count($separate) > 2) {
        //     $query = $separate[2];
        // }
        // Returns an array of products that have the query string located somewhere within
        // our products product name. Paginate them so we can break up lots of search results.
        $search = Product::all();
        if (Input::get('cat_id')!= "all") {
            $check_subcat = Category::where('parent_id',Input::get('cat_id'))->select('id')->get();
            $catid = array();
            foreach ($check_subcat as $value) {
                $catid[] = $value->id;
            }
            $search_result = Product::where('product_name', 'LIKE', '%' . $query . '%')
            ->whereIn('cat_id', $catid)
            ->paginate(200);
            // return dd($search_result);
        }else{
            $search_result = Product::where('product_name', 'LIKE', '%' . $query . '%')->paginate(200);
        }
        if ($search_result->isEmpty()) {
            // flash()->info('Not Found', 'No search results found.');
            return redirect('/');
        }

        // Return a view and pass the view the list of products and the original query.
        $rand_brands = Brand::orderByRaw('RAND()')->take(6)->get();
        return view('pages.search', compact('search', 'search_result', 'query', 'categories', 'brands', 'cart_count', 'rand_brands'));
    }


}