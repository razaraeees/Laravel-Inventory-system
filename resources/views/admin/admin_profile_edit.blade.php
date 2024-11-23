@extends('admin.admin_master')
@section('admin')
<-----JQUERY CDN LINK------!>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<div class="page-content">
        <div class="container-fluid">
    	    <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Profile Page</h4>
                        <form  method= "post" action="{{ route('update.profile')}}" enctype = "multipart/form-data">
                            @csrf
                        <div class="row mb-3 mt-4 ">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="name" type="text" id="example-text-input" value="{{ $profileEdit->name }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">User Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="username" type="text" id="example-text-input" value="{{ $profileEdit->username }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">User Email</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="email" type="text" id="example-text-input" value="{{ $profileEdit->email }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Profile Image</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="profile_image" type="file" id="Image">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <img id = "ImageShow" class="rounded avatar-lg" src="{{!empty($profileEdit->profile_image) 
                                ? url('uploads/admin_image/' .$profileEdit->profile_image)
                                 : url('uploads/no_image_found.jpg') }}" alt="Card image cap">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info waves-effect waves-light"> Update Profile</button>
                        </form>
                        <!-- end row -->
                    </div>
                </div>
            </div> <!-- end col -->
                </div>

    </div>
</div>
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