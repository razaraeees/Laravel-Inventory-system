<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use Auth;
use Illuminate\Support\Carbon;


class UnitController extends Controller
{
    public function unitAll(){

        $units = Unit::latest()->get();
        return view('backend.unit.unit_all', compact('units'));
        
    }////End Method

    public function unitAdd(){

        return view('backend.unit.unit_add');
        
    }////End Method

    public function unitStore(Request $request){
        
        Unit::Insert([
            'name' =>$request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' =>'Unit Inserted Successfully',
            'alert-type' => 'success'
       );


        return redirect()->route('unit.all')->with($notification);
        
    }////End Method

    public function unitEdit($id){

        $unitEdit = Unit::findOrFail($id);
        return view('backend.unit.unit_edit', compact('unitEdit'));
        
    }////End Method

    public function unitUpdate(Request $request){

        $unitUpdate = $request->id;
        Unit::findOrFail($unitUpdate)->update([
            'name' =>$request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' =>'Unit Updated Successfully',
            'alert-type' => 'success'
       );
       return redirect()->route('unit.all')->with($notification);
        
    }////End Method

    public function unitDelete($id){

        Unit::findOrFail($id)->delete();
       
        $notification = array(
            'message' =>'Unit Deleted Successfully',
            'alert-type' => 'success'
       );

       return redirect()->route('unit.all')->with($notification);
        
    }////End Method
}
