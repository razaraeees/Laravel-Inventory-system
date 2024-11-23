<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;

class CategoryController extends Controller
{
    public function categoryAll(){

        $categories = Category::latest()->get();
        return view('backend.category.category_all', compact('categories'));
        
    }////End Method

    public function categoryAdd(){

        return view('backend.category.category_add');
        
    }////End Method

    public function categoryStore(Request $request){

        Category::insert([
            'name' =>$request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 
        ]);
        
        $notification = array(
            'message' =>'Category Inserted Successfully',
            'alert-type' => 'success'
       );

        return redirect()->route('category.all')->with($notification);
    }////End Method

    
    public function categoryEdit($id){

        $categoryEdit = Category::findOrfail($id);
        return view('backend.category.category_edit', compact('categoryEdit'));

    }////End Method

    public function categoryUpdate(Request $request){

        $categoryupdate = $request->id;
        Category::findOrFail($categoryupdate)->update([
            'name' =>$request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(), 
        ]);

        $notification = array(
            'message' =>'Category Updated Successfully',
            'alert-type' => 'success'
       );

        return redirect()->route('category.all')->with($notification);

    }////End Method

    public function categoryDelete($id){

        Category::findOrfail($id)->delete();
        $notification = array(
            'message' =>'Category Deleted Successfully',
            'alert-type' => 'success'
       );

       return redirect()->route('category.all')->with($notification);



    }////End Method


}
