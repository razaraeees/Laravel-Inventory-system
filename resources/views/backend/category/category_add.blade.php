@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="page-content">
        <div class="container-fluid">
    	    <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Category Page</h4>
                        <form  method= "post" action="{{ route('category.store')}}"  id="myForm">
                            @csrf
                        <div class="row mb-3 mt-4">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Category Name</label>
                            <div class="form-group col-sm-10">
                                <input class="form-control" name="name" type="text" placeholder="Category Name">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info waves-effect waves-light"><i class="fas fa-plus-circle"> Add Category</i></button>
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
                        },
                            messages :{
                                name : {
                                     required : 'Please Enter Your Name',
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