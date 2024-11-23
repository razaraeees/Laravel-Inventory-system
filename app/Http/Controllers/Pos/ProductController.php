<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Supplier;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Auth;


class ProductController extends Controller
{
    public function productAll() {

        $product = Product::latest()->get();
        return view('backend.product.product_all', compact('product'));

    }// End Method

    public function productAdd(){

        $suppliers = Supplier::all();
        $units = Unit::all();
        $categories = Category::all();
        return view('backend.product.product_add', compact('suppliers', 'units', 'categories'));
        
    }////End Method

    public function productStore(Request $request){

        Product::insert([
            'name' =>$request->name,
            'supplier_id' =>$request->supplier_id,
            'unit_id' =>$request->unit_id,
            'category_id' =>$request->category_id,
            'quantity' =>'0',
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 
        ]);
        
        $notification = array(
            'message' =>'Product Inserted Successfully',
            'alert-type' => 'success'
       );

        return redirect()->route('product.all')->with($notification);
    }////End Method

    public function productEdit($id){

        $suppliers = Supplier::all();
        $units = Unit::all();
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('backend.product.product_edit', compact('product','suppliers', 'units', 'categories'));
        
    }////End Method

    public function productUpdate(Request $request){

        $product_id = $request->id;
        Product::findOrFail($product_id)->update([
            'name' =>$request->name,
            'supplier_id' =>$request->supplier_id,
            'unit_id' =>$request->unit_id,
            'category_id' =>$request->category_id,
            'quantity' =>'0',
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(), 
        ]);
        
        $notification = array(
            'message' =>'Product Inserted Successfully',
            'alert-type' => 'success'
       );

       return redirect()->route('product.all')->with($notification);
    }
    
    public function productDelete($id){

        Product::findOrFail($id)->delete();
       
        $notification = array(
            'message' =>'Product Deleted Successfully',
            'alert-type' => 'success'
       );

       return redirect()->route('product.all')->with($notification);
        
    }////End Method
}
