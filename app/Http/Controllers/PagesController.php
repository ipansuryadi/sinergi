<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Brand;
use App\Product;
use App\Category;
use App\Slideshow;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Http\Traits\CartTrait;


class PagesController extends Controller {

    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /**
     * Display things for main index home page.
     *
     * @return $this
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

        // Select all products where featured = 1,
        // order by random rows, and only take 4 rows from table so we can display them on the homepage.
        $products = Product::where('featured', '=', 1)->orderByRaw('RAND()')->take(6)->get();

        $rand_brands = Brand::orderByRaw('RAND()')->take(6)->get();

        // Select all products with the newest one first, and where featured = 0,
        // order by random rows, and only take 8 rows from table so we can display them on the New Product section in the homepage.
        $new = Product::orderBy('created_at', 'desc')->where('featured', '=', 0)->orderByRaw('RAND()')->take(6)->get();

        $mostview = Product::orderBy('hits', 'desc')->where('featured', '=', 0)->take(6)->get();

        $slideshow = Slideshow::all();

        return view('pages.index', compact('products', 'brands', 'search', 'new', 'cart_count', 'rand_brands', 'mostview', 'slideshow'))->with('categories', $categories);
    }


    /**
     * Display Products by Category.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function displayProducts($id) {

        // Get the Category ID , so we can display the category name under each list view
        $category = Category::where('id', '=', $id)->get();

        $categories_find = Category::where('id', '=', $id)->find($id);

        // If no category exists with that particular ID, then redirect back to Home page.
        if (!$categories_find) {
            return redirect('/');
        }

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $categories = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        // Get the Products under the Category ID
        $products = Product::where('cat_id','=', $id)->get();

        // Count the products under a certain category
        $count = $products->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();
        $rand_brands = Brand::orderByRaw('RAND()')->take(6)->get();
        return view('category.show', compact('products', 'categories','brands', 'category', 'search', 'cart_count','rand_brands'))->with('count', $count);
    }


    /** Display Products by Brand
     *
     * @param $id
     * @return $this
     */
    public function displayProductsByBrand($id) {

        // Get the Brand ID , so we can display the brand name under each list view
        $brand = Brand::where('id', '=', $id)->get();

        $brands_find = Brand::where('id', '=', $id)->find($id);

        // If no brand exists with that particular ID, then redirect back to Home page.
        if (!$brands_find) {
            return redirect('/');
        }

        // From Traits/CategoryTrait.php
        // ( Show Categories in side-nav )
        $categories = $this->categoryAll();

        // From Traits/BrandAll.php
        // Get all the Brands
        $brands = $this->brandsAll();

        // From Traits/SearchTrait.php
        // ( Enables capabilities search to be preformed on this view )
        $search = $this->search();

        // Get the Products under the Brand ID
        $products = Product::where('brand_id', '=', $id)->get();

        // Count the products under a certain brand
        $count = $products->count();

        // From Traits/CartTrait.php
        // ( Count how many items in Cart for signed in user )
        $cart_count = $this->countProductsInCart();
        $rand_brands = Brand::orderByRaw('RAND()')->take(6)->get();
        return view('brand.show', compact('products', 'brands', 'brand', 'categories', 'search', 'cart_count','rand_brands'))->with('count', $count);
    }

    public function about(){
        $brands = $this->brandsAll();
        $categories = $this->categoryAll();
        $cart_count = $this->countProductsInCart();
        $search = $this->search();
        $rand_brands = Brand::orderByRaw('RAND()')->take(6)->get();
        return view('pages.about',compact('brands', 'categories', 'cart_count','rand_brands', 'search'));
    }

    public function super(){
        return 'super';
    }

}