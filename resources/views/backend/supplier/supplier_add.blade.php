@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="page-content">
        <div class="container-fluid">
    	    <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Supplier Page</h4>
                        <form  method= "post" action="{{ route('supplier.store')}}"  id="myForm">
                            @csrf
                        <div class="row mb-3 mt-4">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Name</label>
                            <div class="form-group col-sm-10">
                                <input class="form-control" name="name" type="text" placeholder="Supplier Name">
                            </div>
                        </div>

                        <div class="row mb-3 mt-4">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Mobile</label>
                            <div class=" form-group col-sm-10">
                                <input class="form-control" name="mobile_no" type="text" placeholder="Supplier Mobile">
                            </div>
                        </div>

                        <div class="row mb-3 mt-4">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Email</label>
                            <div class="form-group col-sm-10">
                                <input class="form-control" name="email" type="text" placeholder="Email">
                            </div>
                        </div>

                        <div class="row mb-3 mt-4">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Address</label>
                            <div class=" form-group col-sm-10">
                                <input class="form-control" name="address" type="text" placeholder="Supplier Address">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info waves-effect waves-light"> Add Supplier</button>
                        </form>
                        <!-- end row -->
                    </div>
                </div>
            </div> <!-- end col -->
                </div>

    </div>
</div>
 <script type="text/javascript">
        $(document).ready(function () {
            $('#myForm').validate({
                rules:{
                        name : {
                             required : true,
                        },
                        mobile_no : {
                             required : true,
                        },
                        email : {
                             required : true,
                        },
                        address : {
                             required : true,
                        },
                        },
                            messages :{
                                name : {
                                     required : 'Please Enter Your Name',
                                },
                                mobile_no : {
                                     required : 'Please Enter Your Mobile Number',
                                },
                                email : {
                                     required : 'Please Enter Your Email ',
                                },
                                address : {
                                     required : 'Please Enter Your Address',
                                },
                            },
                            errorElement : 'span',
                            errorPlacement: function (error,element){
                            error.addClass('invalid-feedback');
                            element.closest('.form-group').append(error);
                            },
                                highlight: function(element,errorClass,validClass){
                                $(element).addClass('is-invalid');
                                },
                                    unhighlight: function(element,errorClass,validClass ){
                                    $(element).removeClass('is-invalid');
                                    },
                    });
         });

 </script>
@endsection