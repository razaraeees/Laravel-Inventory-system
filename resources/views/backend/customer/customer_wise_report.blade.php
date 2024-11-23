@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


 <div class="page-content">
    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">CUSTOMER WISE REPORT</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body"> 
                        <div class="row ">
                            <div class="col-md-12 text-center">
                                <strong>Customer Credit Wise Report</strong>
                                <input type="radio" name="customer_wise_report" value="customer_wise_credit" 
                                class="search_value">&nbsp;&nbsp;

                                <strong>Customer Paid Wise Report</strong>
                                <input type="radio" name="customer_wise_report" value="customer_wise_paid" 
                                class="search_value">
                            </div>  ` 
                        </div>    

                        {{-- Credit Wise --}}
                        <div class="show_credit" style="display: none;">
                            <form id="myForm"  method="GET" action="{{ route('customer.wise.credit.pdf') }}" target="_blank">
                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label>Customer Name</label>
                                        <select name="customer_id" class="form-select select2" aria-label="Default select example">
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $cust)
                                            <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 28px;">
                                        <button type="submit" class="btn btn-info">Search</button>
                                    </div>
                                </div>
                            </form><!-- end form -->    
                        </div> 
                        {{--End Credit Wise --}}


                        {{-- Paid Wise --}}
                        <div class="show_paid" style="display: none;">
                            <form id="myForm"  method="GET" action="{{ route('customer.wise.paid.pdf') }}" target="_blank">
                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label>Customer Name</label>
                                        <select name="customer_id" class="form-select select2" aria-label="Default select example">
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $cust)
                                            <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 28px;">
                                        <button type="submit" class="btn btn-info">Search</button>
                                    </div>
                                </div>
                            </form><!-- end form -->    
                        </div>         
                        {{--End Paid Wise --}}





                    </div><!-- end card bodey -->
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

                     
                        
    </div> <!-- container-fluid -->
</div>



<script type="text/javascript">

    $(document).on('change', '.search_value', function () {
        var search_value = $(this).val();
         if (search_value == 'customer_wise_credit') {
            $('.show_credit').show();
         }else{
            $('.show_credit').hide();
         }
    });

    $(document).on('change', '.search_value', function () {
        var search_value = $(this).val();
         if (search_value == 'customer_wise_paid') {
            $('.show_paid').show();
         }else{
            $('.show_paid').hide();
         }
    });


</script>

@endsection