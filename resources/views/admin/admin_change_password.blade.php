@extends('admin.admin_master')
@section('admin')

<div class="page-content">
        <div class="container-fluid">
    	    <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Change Password Page</h4>
                        <form  method= "post" action="{{ route('update.password')}}" enctype = "multipart/form-data">
                            @csrf
                        <div class="row mb-3 mt-4 @error('oldpassword') has-error @enderror">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Old Password</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="oldpassword" type="password" id="oldpassword" placeholder="Old Password">
                                @error('oldpassword')
                                <div class="label label-danger">Old password does not match</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 mt-4 @error('newpassword') has-error @enderror">
                            <label for="example-text-input" class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="newpassword" type="password" id="newpassword" placeholder="New Password">
                                @error('newpassword')
                                <div class="label label-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 mt-4 @error('confirmpassword') has-error @enderror">
                            <label for=oldpassword-input" class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="confirmpassword" type="password" id="confirmpassword"  placeholder="Retype Please">
                                @error('confirmpassword')
                                <div class="label label-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info waves-effect waves-light"> Update Password</button>
                        </form>
                        <!-- end row -->
                    </div>
                </div>
            </div> <!-- end col -->
                </div>

    </div>
</div>
@endsection