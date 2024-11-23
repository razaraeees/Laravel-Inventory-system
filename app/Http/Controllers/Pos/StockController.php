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


class StockController extends Controller
{
   
    public function StockReport() {

       $AllData = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->get();

       return view('backend.stock.stock_report', compact('AllData'));   
    }

    public function StockReportPdf() {

        $AllData = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->get();
 
        return view('backend.pdf.stock_report_pdf', compact('AllData'));   
     }

     
     public function StockSupplierWise() {

        $suppliers = Supplier::all();
        $categories = Category::all();

        return view('backend.stock.supplier_product_wise_report', compact('suppliers', 'categories'));   
     }

   public function SupplierWisePdf(Request $request) {

      $AllData = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->where
      ('supplier_id',$request->supplier_id)->get();

      return view('backend.pdf.supplier_wise_report_pdf', compact('AllData'));   
   }

   public function ProductWisePdf(Request $request) {

      $product = Product::where('category_id',$request->category_id)->where
      ('id',$request->product_id)->first();

      return view('backend.pdf.product_wise_report_pdf', compact('product'));   
   }

}
