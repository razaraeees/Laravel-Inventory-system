@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="page-content">
        <div class="container-fluid">
    	    <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Customer Page</h4>
                        <form  method= "post" action="{{ route('customer.store')}}"  id="myForm" enctype = "multipart/form-data"> 
                            @csrf
                        <div class="row mb-3 mt-4">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Customer Name</label>
                            <div class="form-group col-sm-10">
                                <input class="form-control" name="name" type="text" placeholder="Customer Name">
                            </div>
                        </div>

                        <div class="row mb-3 mt-4">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Customer Mobile</label>
                            <div class=" form-group col-sm-10">
                                <input class="form-control" name="mobile_no" type="text" placeholder="Customer Mobile">
                            </div>
                        </div>

                        <div class="row mb-3 mt-4">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Customer Email</label>
                            <div class="form-group col-sm-10">
                                <input class="form-control" name="email" type="text" placeholder="Customer Email">
                            </div>
                        </div>

                        <div class="row mb-3 mt-4">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Customer Address</label>
                            <div class=" form-group col-sm-10">
                                <input class="form-control" name="address" type="text" placeholder="Customer Address">
                            </div>
                        </div>
                        <div class="row mb-3 mt-4">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Customer Image</label>
                            <div class="form-group col-sm-10">
                                <input class="form-control" name="customer_image" type="file" id="Image">
                            </div>
                        </div>

                        <div class="row mb-3 mt-4">
                            <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                            <div class="form-group col-sm-10">
                                <img id = "ImageShow" class="rounded avatar-lg" src="{{ url('uploads/no_image_found.jpg') }}" alt="Card image cap">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info waves-effect waves-light"> Add Customer</button>
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
                        customer_image : {
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
                                customer_image : {
                                     required : 'Please Select your Image File',
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

<script>
    $(document).ready(function(){
       $('#Image').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#ImageShow').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
       }); 
    });
</script>

@endsection