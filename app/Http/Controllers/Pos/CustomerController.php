<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\PaymentDetail;

use Auth;
use Illuminate\Support\Carbon;
use Image;

class CustomerController extends Controller
{
     public function customerAll(){
        $customers = Customer::latest()->get();
        return view('backend.customer.customer_all', compact('customers'));
    }//end method

    public function customerAdd(){
        return view('backend.customer.customer_add',);
    }//end method

    public function customerStore(Request $request){
        
        $customer_img = $request->file('customer_image');
        $image_gen = hexdec(uniqid()). '.' .$customer_img->getClientOriginalExtension();
            //343434.png
        Image::make($customer_img)->resize(200,200)->save('uploads/customer/' .$image_gen);
        $save_url = 'uploads/customer/' . $image_gen;

        Customer::insert([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'customer_image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' =>'Customer Inserted Successfully',
            'alert-type' => 'success'
       );

       return redirect()->route('customer.all')->with($notification);

    }//end method

    public function customerEdit($id){

        $customerData = Customer::findOrFail($id);
        return view('backend.customer.customer_edit', compact('customerData'));
    }//end method

    public function customerUpdate( Request $request){
        
        $customer_id = $request->id;
        $customer = Customer::findOrFail($customer_id);

        if ($request->file('customer_image')) {

            $old_img = $customer->customer_image;
            if (file_exists($old_img)) {
                unlink($old_img);
            }

            $customer_img = $request->file('customer_image');

            $image_gen = hexdec(uniqid()). '.' .$customer_img->getClientOriginalExtension();
                //343434.png
            Image::make($customer_img)->resize(200,200)->save('uploads/customer/' .$image_gen);
            $save_url = 'uploads/customer/' . $image_gen;

            $customer->update([

                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'address' => $request->address,
                'customer_image' => $save_url,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);
            $notification = array(
                'message' =>'Customer Updated Successfully',
                'alert-type' => 'success'
       );

            return redirect()->route('customer.all')->with($notification);
        }
        else{

            Customer::findOrFail($customer_id)->update([

                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'address' => $request->address,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);
            $notification = array(
                'message' =>'Customer Updated Without Image Successfully',
                'alert-type' => 'success'
       );

            return redirect()->route('customer.all')->with($notification);            

        }
        
    }//end method

    
    public function CustomerDelete($id){

         $customers = Customer::findOrFail($id);
         $deleteImg = $customers->customer_image;
         unlink($deleteImg);

         Customer::findOrFail($id)->delete();
         $notification = array(
            'message' =>'Customer Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification);

    }//end method

    public function CustomerCredit() {

        $allData = Payment::whereIn('paid_status', ['partial_paid', 'full_due'])->get();
        return view('backend.customer.customer_credit', compact('allData'));


    }//End Method

    public function CustomerCreditPdf() {
        
        $allData = Payment::whereIn('paid_status', ['partial_paid', 'full_due'])->get();
        return view('backend.pdf.customer_credit_pdf', compact('allData'));

    }//End Method

    public function EditCustomerInvoice($invoice_id) {
        
        $payment = Payment::where('invoice_id',$invoice_id)->first();
        return view('backend.customer.edit_customer_invoice', compact('payment'));

    }//End Method

    public function CustomerUpdateInvoice(Request $request, $invoice_id) {
        
        if ($request->new_paid_amount < $request->paid_amount ) {

            $notification = array(
                'message' =>'Sorry You Paid Maximum Value',
                'alert-type' => 'error'
           );
    
            return redirect()->back()->with($notification);
        }else{
            $payment = Payment::where('invoice_id',$invoice_id)->first();
            $payment_details = new PaymentDetail();
            $payment->paid_status = $request->paid_status;

            if ($request->paid_status == 'full_paid') {
                $payment->paid_amount = Payment::where('invoice_id',$invoice_id)->
                first()['paid_amount']+$request->new_paid_amount;
                $payment->due_amount = '0';
                $payment_details->current_paid_amount = $request->new_paid_amount;

            }elseif($request->paid_status == 'partial_paid') 
            {
                $payment->paid_amount = Payment::where('invoice_id',$invoice_id)->
                    first()['paid_amount']+$request->paid_amount;

                $payment->due_amount = Payment::where('invoice_id',$invoice_id)->
                    first()['due_amount']-$request->paid_amount;

                $payment_details->current_paid_amount = $request->paid_amount;
            }
            $payment->save();
            $payment_details->invoice_id = $invoice_id;
            $payment_details->date = date('Y-m-d', strtotime($request->date));
            $payment_details->updated_by = Auth::user()->id;
            $payment_details->save();

            $notification = array(
                'message' =>'Invoice Updated SuccessFully',
                'alert-type' => 'success'
           );
    
            return redirect()->route('customer.credit')->with($notification);

        }//End Else

    }//End Method

    public function CustomerInvoicedetailsPdf($invoice_id) {

        $payment = Payment::where('invoice_id',$invoice_id)->first();
        return view('backend.pdf.customer_invoice_details_pdf', compact('payment'));

    }

    public function CustomerPaid() {

        $allData = Payment::where('paid_status', '!=', 'full_due')->get();
        return view('backend.customer.customer_paid', compact('allData'));

    }

    public function CustomerPaidPdf() {

        $allData = Payment::where('paid_status', '!=', 'full_due')->get();
        return view('backend.pdf.customer_paid_pdf', compact('allData'));

    }

    public function CustomerWiseReport() {

        $customers = Customer::all();
        return view('backend.customer.customer_wise_report', compact('customers'));

    }

    public function CustomerWiseCreditPdf(Request $request) {

        $allData = Payment::where('customer_id', $request->customer_id)->whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        return view('backend.pdf.customer_wise_credit_pdf', compact('allData'));

    }

    public function CustomerWisePaidPdf(Request $request) {

        $allData = Payment::where('customer_id', $request->customer_id)->where('paid_status', '!=', 'full_due')->get();
        return view('backend.pdf.customer_wise_paid_pdf', compact('allData'));

    }
}
