@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Invoice</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                            <li class="breadcrumb-item active">Invoice</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">
                                    <h4 class="float-end font-size-16"><strong>Invoice # : {{$invoice->invoice_no}}</strong></h4>
                                    <h3>
                                        <img src="/backend/assets/images/logo-sm.png" alt="logo" height="24"/> Easy Shopping Mall
                                    </h3>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6 mt-4">
                                        <address>
                                            <strong>Easy Shoping Mall :</strong><br>
                                            The center Mall Sadar Karachi<br>
                                            easyshop@gmail.com
                                        </address>
                                    </div>
                                    <div class="col-6 mt-4 text-end">
                                        <address>
                                            <strong>Invoice Date:</strong><br>
                                            {{ date('d-m-Y', strtotime($invoice->date)) }}<br><br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                @php
                $payment = App\Models\Payment::where('invoice_id', $invoice->id)->first();   
                @endphp                

            <div class="row">
                <div class="col-12">
                    <div>
                        <div class="p-2">
                            <h3 class="font-size-16"><strong>Customer Invoice</strong></h3>
                        </div>
                        <div class="">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td><strong>Customer Name</strong></td>
                                        <td class="text-center"><strong> Cutomer Mobile</strong></td>
                                        <td class="text-center"><strong>Email</strong></td>
                                        <td class="text-center"><strong>Description</strong></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                    <tr>
                                        <td>{{ $payment['customer']['name'] }}</td>
                                        <td class="text-center">{{ $payment['customer']['mobile_no'] }}</td>
                                        <td class="text-center">{{ $payment['customer']['email'] }}</td>
                                        <td class="text-center">{{ $invoice->description }}</td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div> <!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div>
                        <div class="p-2">
                            <h3 class="font-size-16"><strong></strong></h3>
                        </div>
                        <div class="">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td><strong>SI</strong></td>
                                        <td class="text-center"><strong> Category Name</strong></td>
                                        <td class="text-center"><strong>Product Name</strong></td>
                                        <td class="text-center"><strong>Current Stock</strong></td>
                                        <td class="text-center"><strong>Quantity</strong></td>
                                        <td class="text-center"><strong>Unit Price</strong></td>
                                        <td class="text-center"><strong>Total Price</strong></td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $total_sum = '0';
                                    @endphp
                                    @foreach($invoice['invoice_details'] as $key => $details)
                                    <tr>
                                        <td class="text-center">{{ $key+1 }}</td>
                                        <td class="text-center">{{ $details['category']['name'] }}</td>
                                        <td class="text-center">{{ $details['product']['name'] }}</td>
                                        <td class="text-center">{{ $details['product']['quantity'] }}</td>
                                        <td class="text-center">{{ $details->selling_qty }}</td>
                                        <td class="text-center">{{ $details->unit_price }}</td>
                                        <td class="text-center">{{ number_format($details->selling_price) }}</td>  
                                    </tr>
                                    @php
                                    $total_sum += $details->selling_price;
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line">
                                            <strong>Subtotal</strong></td>
                                        <td class="thick-line text-end">{{ number_format($total_sum) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line ">
                                            <strong>Discount Amount</strong></td>
                                        <td class="no-line text-end">{{ number_format( $payment->discount_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line">
                                            <strong>Paid Amount</strong></td>
                                        <td class="no-line text-end"><h5 class="m-0">{{ number_format($payment->paid_amount) }}</h5></td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line">
                                            <strong>Due Amount</strong></td>
                                        <td class="no-line text-end"><h5 class="m-0">{{ number_format($payment->due_amount) }}</h5></td>
                                    </tr>

                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line">
                                            <strong>Grand Total</strong></td>
                                        <td class="no-line text-end"><h5 class="m-0">{{ number_format($payment->total_amount) }}</h5></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-print-none">
                                <div class="float-end">
                                    <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                    <a href="#" class="btn btn-primary waves-effect waves-light ms-2">Send</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> <!-- end row -->

            

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

@endsection