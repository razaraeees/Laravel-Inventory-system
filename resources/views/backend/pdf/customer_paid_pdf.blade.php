@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Customer Paid Report</h4>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">
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
                                    </div>
                                </div>
                            </div>
                        </div>             

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
                                        <td class="text-center"><strong> Customer Name</strong></td>
                                        <td class="text-center"><strong>Invoice No</strong></td>
                                        <td class="text-center"><strong>Date</strong></td>
                                        <td class="text-center"><strong>Due Amount</strong></td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $total_due = '0';
                                    @endphp
                                    @foreach($allData as $key => $item)
                                    <tr>
                                        <td class="text-center"> {{ $key+1}} </td>
                                        <td class="text-center"> {{ $item['customer']['name'] }} </td> 
                                        <td class="text-center"> {{ $item['invoice']['invoice_no'] }} </td>  
                                        <td class="text-center"> {{ date('d-m-Y', strtotime($item['invoice']['date'])) }} </td> 
                                        <td class="text-center"> {{ number_format( $item->due_amount ) }} </td>  
                                    </tr>
                                    @php
                                    $total_due += $item->due_amount;
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center">
                                            <strong>Grand Total</strong></td>
                                        <td class="no-line text-end"><h5 class="m-0">{{ number_format($total_due) }}</h5></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            @php
                             $date = new DateTime('now', new DateTimeZone('Asia/Karachi'))   
                            @endphp
                            <i>Printing Time: {{ $date->format('F j, Y, g:i a') }}</i>

                            <div class="d-print-none">
                                <div class="float-end">
                                    <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                    <a href="#" class="btn btn-primary waves-effect waves-light ms-2">Download</a>
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