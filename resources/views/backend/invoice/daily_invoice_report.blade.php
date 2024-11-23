@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="page-content">
        <div class="container-fluid">
    	 <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <h4 class="card-title">Daily Invoice Report</h4><br><br>
                    <form id="formdate" target="_blank" method="GET" action="{{ route('daily.invoice.pdf') }}">
                        @csrf
                    <div class="row">
                        <div class="col-md-4 ">
                            <div class="md-3 form-group">
                                <label for="example-text-input" class="form-label"><strong>Start Date</strong></label>
                                <input class="form-control example-date-input" name="start_date" type="date" id="start_date"
                                 placeholder="YY-MM-DD">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="md-3 form-group">
                                <label for="example-text-input" class="form-label"><strong>End Date</strong></label>
                                <input class="form-control example-date-input" name="end_date" type="date" id="end_date"
                                 placeholder="YY-MM-DD">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="md-3">
                                <label for="example-text-input" class="form-label" style="margin-top: 2.8rem;"></label>
                                <button type="submit" class="btn btn-info">Search</button>
                            </div>
                        </div>
                    </div> <!--end row-->   

                </form>
                    </div>

                   

                </div>
            </div> <!-- end col -->
         </div>

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#formdate').validate({
            rules:{
                    start_date : {
                         required : true,
                    },
                    end_date : {
                         required : true,
                    },
                    },
                        messages :{
                            start_date : {
                                 required : 'Please Select Your Start Date',
                            },
                            end_date : {
                                 required : 'Please Select Your End date',
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