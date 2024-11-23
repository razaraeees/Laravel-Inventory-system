@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="page-content">
        <div class="container-fluid">
    	    <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Product Page</h4>
                        <form  method= "post" action="{{ route('product.update')}}"  id="myForm">
                            @csrf
                         <input type="hidden" name="id" value="{{ $product->id }}">   
                        <div class="row mb-3 mt-4">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Product Name</label>
                            <div class="form-group col-sm-10">
                                <input class="form-control" name="name" type="text" value="{{ $product->name }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Supplier Name</label>
                            <div class="col-sm-10">
                                <select name="supplier_id" class="form-select" aria-label="Default select example">
                                    <option selected="">Open this select menu</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ $supplier->id == $product->supplier_id ? 'selected' : '' }} >{{ $supplier->name }}</option>
                                    @endforeach
                                    </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Unit Name</label>
                            <div class="col-sm-10">
                                <select name="unit_id" class="form-select" aria-label="Default select example">
                                    <option selected="">Open this select menu</option>
                                    @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ $unit->id == $product->unit_id ? 'selected' : '' }} >{{ $unit->name }}</option>
                                    @endforeach
                                    </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Category Name</label>
                            <div class="col-sm-10">
                                <select name="category_id" class="form-select" aria-label="Default select example">
                                    <option selected="">Open this select menu</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }} >{{ $category->name }}</option>
                                    @endforeach
                                    </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info waves-effect waves-light"> Update Product</button>
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
                        supplier_id : {
                             required : true,
                        },
                        unit_id : {
                             required : true,
                        },
                        category_id : {
                             required : true,
                        },
                        },
                            messages :{
                                name : {
                                     required : 'Please Enter Your Name',
                                },
                                supplier_id : {
                                     required : 'Please Select Your One Supplier ',
                                },
                                unit_id : {
                                     required : 'Please Select Your One Unit',
                                },
                                category_id : {
                                     required : 'Please Select Your One Category',
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