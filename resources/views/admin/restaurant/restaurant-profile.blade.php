@extends('admin/layouts/default')
@section('title')
<title>Restaurant Profile</title>
@stop

@section('inlinecss')
<link href="{{ asset('admin/assets/multiselectbox/css/multi-select.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Restaurant Profile</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Restaurant Profile</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
</ol>
@stop

@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!--  Start Content -->
    <form id="submitForm" class="row"  method="post" action="{{route('restaurant-update')}}">
        {{csrf_field()}}
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Restaurant Info</h3>
									</div>
									<div class="card-body">
                                    
										<div class="form-group">
											<label class="form-label">Restaurant Name*</label>
											<input type="text" class="form-control" name="name" id="name" value="{{$restaurant->name}}" >
										</div>
										
										

                                        
										<div class="form-group">
											<label class="form-label">Mobile No *</label>
											<input type="text" class="form-control" name="mobile" id="mobile" value="{{$restaurant->mobile}}" >
										</div>
										
										<div class="form-group">
											<label class="form-label">Banner Image </label>
											<input type="file" class="form-control" name="banner_image" id="banner_image" placeholder="">
                                            <img id="banner_image_select" src="{{ asset(''.($restaurant->banner_image)?$restaurant->banner_image:'uploads/banner/default.jpg') }}" style="width:100%">
										</div>
                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>
                                        
										</div>
                                        
									</div>
                                    
								</div>
							
							
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Restaurant Address</h3>
									</div>
									<div class="card-body">
                                    
										

                                        <div class="form-group">
											<label class="form-label">Address *</label>
											<input type="text" class="form-control" name="address" id="address" value="{{$restaurant->address}}">
										</div>
										
										<div class="form-group">
											<label class="form-label">City *</label>
											<input type="text" class="form-control" name="city" id="city" value="{{$restaurant->city}}">
										</div>

                                        
										<div class="form-group">
											<label class="form-label">State *</label>
											<input type="text" class="form-control" name="state" id="state" value="{{$restaurant->state}}">
										</div>
                                        
									</div>
                                    
								</div>
							
							
							
							</form>
        </div><!-- COL END -->
        <!--  End Content -->

    </div>
</div>

@stop
@section('inlinejs')
<script src="{{ asset('admin/assets/multiselectbox/js/jquery.multi-select.js') }}"></script>          
    <script type="text/javascript">
        
        $(function () { 
            $('#roles').multiSelect();
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
                        successMsg('Edit Restaurant', data.msg);                    

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Edit Restaurant','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Edit Restaurant', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });
		   
		    $("#banner_image").change(function(){
                readURL(this);
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#banner_image_select').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            
       
    </script>
@stop