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

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Customer;
use DB;


class InvoiceController extends Controller
{
    public function invoiceAll(){
        $allData = Invoice::orderBy('created_at', 'desc')->orderBy('id', 'desc')->where('status', '1')->get();
        return view('backend.invoice.invoice_all', compact('allData'));
             
    }//End Method
    public function invoiceAdd(){

        $categories = Category::all();
        $customer = Customer::all();
        $invoice_data = Invoice::orderBy('id', 'desc')->first();
        if ($invoice_data == null) {
            $firstReg = '0';
            $invoice_no = $firstReg+1; 
        }else{
            $invoice_data = Invoice::orderBy('id', 'desc')->first()->invoice_no;
            $invoice_no = $invoice_data+1; 
        }
        return view('backend.invoice.invoice_add', compact('invoice_no', 'categories', 'customer'));

    }//End Method  

    public function invoiceStore(Request $request){

        if ($request->category_id == null) {

            $notification = array(
                'message' =>'Sorry you do not select any item ',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
         }else{

            if($request->paid_amount > $request->estimated_amount) {

                $notification = array(
                    'message' =>'Sorry Paid Amount is Maximum the total price',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
                
             }else{

                    $invoice = new Invoice();
                    $invoice->date = date('Y-m-d',strtotime($request->date));
                    $invoice->invoice_no = $request->invoice_no;
                    $invoice->description = $request->description;
                    $invoice->status = '0';
                    $invoice->created_by = Auth::user()->id;

                    DB::transaction(function() use($request, $invoice) {
                        if ($invoice->save()) {

                            $count_category = count($request->category_id);
                            for ($i=0; $i < $count_category ; $i++)  { 

                               $invoice_detail = new InvoiceDetail();
                               $invoice_detail->date = date('Y-m-d',strtotime($request->date));
                               $invoice_detail->invoice_id = $invoice->id;
                               $invoice_detail->category_id	 = $request->category_id[$i]; 
                               $invoice_detail->product_id = $request->product_id[$i]; 
                               $invoice_detail->selling_qty	 = $request->selling_qty[$i]; 
                               $invoice_detail->unit_price = $request->unit_price[$i];
                               $invoice_detail->selling_price = $request->selling_price[$i]; 
                               $invoice_detail->status	 = '0'; 
                               $invoice_detail->save();
                            }
                        if ($request->customer_id == '0') {
                            $customers = new Customer();
                            $customers->name = $request->name;
                            $customers->mobile_no = $request->mobile_no;                                
                            $customers->email = $request->email;                                
                            $customers->save();
                            $customer_id = $customers->id;                                
                        }else{
                            $customer_id = $request->customer_id;
                        }

                        $payment = new Payment();
                        $payment_detail = new PaymentDetail();

                        $payment->invoice_id =  $invoice->id;
                        $payment->customer_id =  $customer_id;
                        $payment->paid_status =  $request->paid_status;
                        $payment->discount_amount =  $request->discount_amount;
                        $payment->total_amount =  $request->estimated_amount;

                        if($request->paid_status == 'full_paid' ){
                             $payment->paid_amount = $request->estimated_amount;
                             $payment->due_amount = '0';
                             $payment_detail->current_paid_amount = $request->estimated_amount;                         
                        }
                        elseif($request->paid_status == 'full_due' ){
                             $payment->paid_amount = '0';
                             $payment->due_amount = $request->estimated_amount;
                             $payment_detail->current_paid_amount = '0';                         
                        }
                        elseif($request->paid_status == 'partial_paid' ){
                             $payment->paid_amount = $request->paid_amount;
                             $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                             $payment_detail->current_paid_amount = $request->paid_amount;                         
                        }
                        $payment->save();

                        $payment_detail->invoice_id = $invoice->id;
                        $payment_detail->date = date('Y-m-d',strtotime($request->date));;
                        $payment_detail->save();
                      }

                    });

                 }//End Else
             }
            
             $notification = array(
                'message' =>'Invoice Data Inserted Successfully ',
                'alert-type' => 'success'
            );
            return redirect()->route('invoice.pending.list')->with($notification);


    }//End Method
     public function invoicePendingList(){

        $allData = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '0')->get();
        return view('backend.invoice.invoice_pending_list', compact('allData'));
             
    }//End Method

    public function invoiceDelete($id){
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        InvoiceDetail::where('invoice_id',$invoice->id)->delete();
        Payment::where('invoice_id',$invoice->id)->delete();
        PaymentDetail::where('invoice_id',$invoice->id)->delete();

        $notification = array(
            'message' =>'Data Delete Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }//End Method

    public function invoiceApprove($id){

        $invoice = Invoice::with('invoice_details')->findOrFail($id);
        return view('backend.invoice.invoice_approve', compact('invoice'));
             
    }//End Method

    public function approveStore(Request $request, $id){

        foreach($request->selling_qty as $key => $val){
            $invoice_details = InvoiceDetail::where('id',$key)->first();
            $product = Product::where('id',$invoice_details->product_id)->first();
             if ($product->quantity < $request->selling_qty[$key] ) {
                $notification = array(
                    'message' =>'Sorry only ' . $product->quantity . ' pieces are available in stock, but you requested ' . $request->selling_qty[$key] . ' pieces.',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
             }  
        }// End foreach

        $invoice = Invoice::findOrFail($id);
        $invoice->updated_by = Auth::user()->id;
        $invoice->status = '1';
             
        DB::transaction(function() use($request,$invoice,$id) {
            foreach($request->selling_qty as $key => $val){
                $invoice_details = InvoiceDetail::where('id',$key)->first();
                $invoice_details->status = '1';
                $invoice_details->save();
                $product = Product::where('id',$invoice_details->product_id)->first();
                $product->quantity = ((float)$product->quantity) - ((float)$request->selling_qty[$key]);        
                $product->save();
            }//End Loop   
            $invoice->save();
            
        });//END DB FUNCTION
        $notification = array(
            'message' =>' Invoice Data Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('invoice.add')->with($notification);            

    }//End Method

    public function invoicePrintList() {
        
        $allData = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '1')->get();
        return view('backend.invoice.invoice_print_list', compact('allData'));

    }//END METHOD

    public function printInvoice($id) {
     
        $invoice = Invoice::with('invoice_details')->findOrFail($id);
        return view('backend.pdf.invoice_pdf', compact('invoice'));
    }//END METHOD

    public function dailyInvoiceReport() {

        return view('backend.invoice.daily_invoice_report');

    }//END METHOD

    public function dailyInvoicePdf(Request $request) {

        $Sdate = date('Y-m-d', strtotime($request->start_date));
        $Edate = date('Y-m-d', strtotime($request->end_date));
        $Alldata = Invoice::whereBetween('date',[$Sdate,$Edate])->where('status', '1')->get();


        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));
        return view('backend.pdf.daily_invoice_pdf', compact('Alldata', 'start_date', 'end_date'));

    }//END METHOD

}
