@extends('admin/layouts/default')
@section('title')
<title>Edit Menu</title>
@stop

@section('inlinecss')
<link href="{{ asset('admin/assets/multiselectbox/css/multi-select.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Edit Menu</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Menu</a></li>
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
    <form id="submitForm"  method="post" action="{{route('menu-update', $menu->id)}}">
		<div class="row" >
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Menu Forms</h3>
									</div>
									<div class="card-body">
                                    {{csrf_field()}}
										<div class="form-group">
											<label class="form-label"> Title *</label>
											<input type="text" class="form-control" name="title" id="title" value="{{$menu->title}}">
										</div>

                                        <div class="form-group">
											<label class="form-label">Type</label>
											<select name="type" id="type" class="form-control custom-select">
												<option @if($menu->type == 1) selected @endif value="1">Veg</option>
												<option @if($menu->type == 0) selected @endif value="0">Non-Veg</option>
											</select>
                                        </div>

										<div class="form-group">
											<label class="form-label"> Description *</label>
											<textarea type="text" class="form-control" name="description" id="description">{{$menu->description}}</textarea>
										</div>
                                       

										<div class="form-group">
											<label class="form-label">Category *</label>
											<select name="category_ids[]" id="category_ids" multiple="multiple" class="multi-select form-control">
                                                @foreach($category as $cat)
                                                <option @if(in_array($cat->id, json_decode($menu->category_ids))) selected @endif value="{{$cat->id}}">{{$cat->category_title}}</option>
                                                @endforeach
											</select>
										</div>	
					
										<div class="form-group">
											<label class="form-label">Image </label>
											<input type="file" class="form-control" name="image" id="image" placeholder="">
                                            <img id="image_select" src="{{ asset(''.$menu->image) }}" style="width:100px">
										</div>
										
                                        			
                                        <div class="form-group">
											<label class="form-label">Status</label>
											<select name="status" id="status" class="form-control custom-select">
												<option @if($menu->status == 1) selected @endif value="1">Active</option>
												<option @if($menu->status == 0) selected @endif value="0">InActive</option>
											</select>
                                        </div>
										
                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>
                                        
										</div>
                                       
									</div>
                                    
								</div>
								
						<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Price List</h3>
									</div>
									<div class="card-body">
                                    <table>
									<tr>
										<th>Price Title *</th>
										<th>Price *</th>
										<th></th>
									</tr>
									@foreach($menu->price_list as $price)
									<tr data-duplicate="dup">
										<td>
										<div class="form-group">
											<input type="text" class="form-control" name="price_title[]" id="price_title" value="{{$price->price_title}}" required>
										</div>
										</td>
										<td>
										<div class="form-group">
											<input type="number" class="form-control" name="price[]" id="price" value="{{$price->price}}" required>
										</div>
										</td>
										<td>
											<button type="button" class="btn btn-primary btn-sm mb-1 addrow" data-duplicate-add="dup">+</button>
                                            <button type="button" class="btn btn-primary btn-sm mb-1 removerow" data-duplicate-remove="dup">-</button>
                                                
										</td>
									</tr>
									
									@endforeach
									
									</table>
                                   
                                    </div>
                                        
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
<script src="{{ asset('admin/assets/js/jquery.duplicate.js') }}"></script> 
    <script type="text/javascript">
        
        $(function () { 
		$('.multi-select').multiSelect();
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

                        successMsg('Update Menu', data.msg);

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Create Menu','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Update Menu', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });
		   
		    $("#image").change(function(){
                readURL(this);
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#image_select').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

           });

          
    </script>
@stop