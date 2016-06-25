<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UnitRequest;
use App\Http\Traits\CartTrait;
use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
	use CartTrait;
    public function index(){
    	$cart_count = $this->countProductsInCart();
    	$units = Unit::all();
    	return view('admin.unit.index', compact('units','cart_count'));
    }
    public function create(){
    	$cart_count = $this->countProductsInCart();
    	return view('admin.unit.create', compact('cart_count'));
    }

    public function store(UnitRequest $request){
    	$unit = new Unit($request->all());
    	$unit->save();
    	return redirect()->route('admin.unit.index');
    }

    public function edit($id){
    	$unit = Unit::findOrFail($id);
    	$cart_count = $this->countProductsInCart();
    	return view('admin.unit.edit', compact('unit','cart_count'));
    }

    public function update($id, UnitRequest $request){
    	$unit = Unit::findOrFail($id);
    	$unit->update($request->all());
    	return redirect()->route('admin.unit.index');
    }

    public function destroy($id){
    	$unit = Unit::findOrFail($id);
    	$unit->delete();
    	return redirect()->back();
    }
}
