@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Purchase</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                            <li class="breadcrumb-item active">Purchase</li>
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
                <h3 class="font-size-16"><strong>Daily Purchase Report
                <span class="btn btn-info">{{ date('m-d-Y', strtotime($start_date)) }}</span>                                
                <span class="btn btn-success">{{ date('m-d-Y', strtotime($end_date)) }}</span>                                
                </strong></h3>
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
                                        <td class="text-center"><strong>Purchase No</strong></td>
                                        <td class="text-center"><strong>Date</strong></td>
                                        <td class="text-center"><strong>Product Name</strong></td>
                                        <td class="text-center"><strong>Quantity</strong></td>
                                        <td class="text-center"><strong>Unit Price</strong></td>
                                        <td class="text-center"><strong>Total Price</strong></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $total_sum = '0';
                                    @endphp
                                    @foreach($Alldata as $key => $items)
                                    <tr>
                                        <td class="text-center">{{ $key+1 }}</td>
                                        <td class="text-center">{{ $items->purchase_no }}</td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($items->date)) }}</td>
                                        <td class="text-center">#{{ $items['product']['name'] }}</td>
                                        <td class="text-center">{{ $items->buying_qty }} {{ $items['product']['unit']['name'] }}</td>
                                        <td class="text-center">{{ number_format($items->unit_price) }}</td>
                                        <td class="text-center">{{ number_format($items->buying_price) }}</td>  
                                    </tr>
                                    @php
                                    $total_sum += $items->buying_price;
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center">
                                            <strong>Grand Total</strong></td>
                                        <td class="no-line text-end"><h5 class="m-0">{{ number_format($total_sum) }}</h5></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

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