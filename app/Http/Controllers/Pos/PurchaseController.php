<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Purchase;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use Auth;
use Illuminate\Support\Carbon;


class PurchaseController extends Controller
{
    public function purchaseAll(){

        $allData = Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        return view('backend.purchase.purchase_all', compact('allData'));
    }

    public function purchaseAdd(){

        $supplier = Supplier::all();
        $category = Category::all();
        $product = Product::all();
        $unit = Unit::all();

        return view('backend.purchase.purchase_add', compact('supplier', 'category', 'product', 'unit' ));
        
    }

    public function purchaseStore(Request $request){
        
        if ($request->category_id == null) {
            $notification = array(
                'message' =>'Customer Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }else{

            $count_category = count($request->category_id);
            for ($i=0; $i < $count_category; $i++) { 
                $purchase = new Purchase();

                $purchase->date = date('Y-m-d', strtotime($request->date[$i]));
                $purchase->purchase_no = $request->purchase_no[$i];
                $purchase->supplier_id = $request->supplier_id[$i];

                $purchase->category_id = $request->category_id[$i];
                $purchase->product_id = $request->product_id[$i];
                $purchase->buying_qty = $request->buying_qty[$i];
                $purchase->unit_price = $request->unit_price[$i];
                $purchase->buying_price = $request->buying_price[$i];
                $purchase->description = $request->description[$i];

                $purchase->created_by = Auth::user()->id;
                $purchase->status = '0';
                $purchase->save();
            }//End loop

        }//End Else 
        $notification = array(
            'message' =>'Data Save Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('purchase.all')->with($notification);

    }//End Method
    public function purchaseDelete($id){

        Purchase::findOrFail($id)->delete();
        $notification = array(
            'message' =>'Purchase Item Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

    public function purchasePending(){

        $allData = Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '0')->get();
        return view('backend.purchase.purchase_pending', compact('allData'));
    }

    public function purchaseApprove($id){

            $purchase = Purchase::findOrFail($id);
            $product = Product::where('id', $purchase->product_id)->first();
            $purchase_qty = ((float)($purchase->buying_qty))+((float)($product->quantity));
            $product->quantity = $purchase_qty;
            
            if ($product->save()) {
                
                Purchase::findOrFail($id)->update([
                    'status' => '1',
                ]);
                $notification = array(
                    'message' =>'Status Approved Successfully',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);                

            }

    }

    public function DailyPurchaseReport() {

        return view('backend.purchase.daily_purchase_report');

    }//END METHOD

    public function DailyPurchaseReportPdf(Request $request) {

        $Sdate = date('Y-m-d', strtotime($request->start_date));
        $Edate = date('Y-m-d', strtotime($request->end_date));
        $Alldata = Purchase::whereBetween('date',[$Sdate,$Edate])->where('status', '1')->get();


        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));
        return view('backend.pdf.daily_purchase_report_pdf', compact('Alldata', 'start_date', 'end_date'));

    }//END METHOD

}
