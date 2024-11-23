@extends('admin.admin_master')
@section('admin')
		<div class="page-content">
                    <div class="container-fluid">
         	  <div class="row">
                  <div class="col-md-6 col-xl-3">

                    <!-- Simple card -->
                    <div class="card">
                    	<br>
                    <center>
                        <img class="rounded-circle avatar-xl" src="{{!empty($profileData->profile_image) 
                        ? url('uploads/admin_image/' .$profileData->profile_image)
                         : url('uploads/no_image_found.jpg') }}" alt="Card image cap">
                    </center>
                        <div class="card-body">
                            <h4 class="card-title">Name : {{ $profileData->name }}</h4>
                            <hr>
                            <h4 class="card-title">User Name : {{ $profileData->username }}</h4>
                            <hr>
                            <h4 class="card-title">Email : {{ $profileData->email }}</h4>
                       		<hr>
                       		<a href="{{ route('edit.profile') }}" class="btn btn-primary btn-rounded waves-effect waves-light">Edit Profile</a>
                       	 </div>
                    </div>

                </div><!-- end col -->
            </div>

           </div>
        </div>
@endsection