@extends('admin/layouts/default')
@section('title')
<title>Edit Table</title>
@stop

@section('inlinecss')
<link href="{{ asset('admin/assets/multiselectbox/css/multi-select.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Edit Table</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Table</a></li>
    <li class="breadcrumb-item active" aria-current="page">edit</li>
</ol>
@stop

@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!--  Start Content -->
    
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Table Forms</h3>
									</div>
									<div class="card-body">
                                    <form id="submitForm"  method="post" action="{{route('table-update', $table->id)}}">
                                    {{csrf_field()}}
										<div class="form-group">
											<label class="form-label"> Table No. *</label>
											<input type="text" class="form-control" name="table_no" id="table_no" value="{{$table->table_no}}">
										</div>

										
                                        			
                                        <div class="form-group">
											<label class="form-label">Status</label>
											<select name="status" id="status" class="form-control custom-select">
												<option @if($table->status == 1) selected @endif value="1">Active</option>
												<option @if($table->status == 0) selected @endif value="0">InActive</option>
											</select>
                                        </div>
										
                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>
                                        
										</div>
                                        </form>
									</div>
                                    
								</div>
							</div><!-- COL END -->
							
							
        
        <!--  End Content -->

    </div>
</div>

@stop
@section('inlinejs')           
<script src="{{ asset('admin/assets/multiselectbox/js/jquery.multi-select.js') }}"></script> 
    <script type="text/javascript">
        
        $(function () { 
           $('#submitForm').submit(function(){
            var $this = $('#submitButton');
            buttonLoading('loading', $this);
            $('.is-invalid').removeClass('is-invalid state-invalid');
            $('.invalid-feedback').remove();
            $.ajax({
                url: $('#submitForm').attr('action'),
                type: "POST",
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: new FormData($('#submitForm')[0]),
                success: function(data) {
                    if(data.status){

                        successMsg('Update Table', data.msg);

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Create Table','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Update Table', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });
		   
		    

           });

          
    </script>
@stop