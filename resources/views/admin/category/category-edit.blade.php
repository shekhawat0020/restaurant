@extends('admin/layouts/default')
@section('title')
<title>Edit Category</title>
@stop

@section('inlinecss')
@stop

@section('breadcrum')
<h1 class="page-title">Edit Category</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Category</a></li>
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
										<h3 class="card-title">Category Forms</h3>
									</div>
									<div class="card-body">
                                    <form id="submitForm"  method="post" action="{{route('category-update', $category->id)}}">
                                    {{csrf_field()}}
										<div class="form-group">
											<label class="form-label">Category Title *</label>
											<input type="text" class="form-control" name="category_title" id="category_title" value="{{$category->category_title}}">
										</div>

                                       

										<div class="form-group">
											<label class="form-label">Parent Category *</label>
											<select name="parent_category" id="parent_category" class="form-control">
												<option value="0">Select Category</option>
                                                @foreach($pCategory as $cat)
                                                <option @if($category->parent_category == $cat->id) selected @endif value="{{$cat->id}}">{{$cat->category_title}}</option>
                                                @endforeach
											</select>
										</div>						
                                        <div class="form-group">
											<label class="form-label">Status</label>
											<select name="status" id="status" class="form-control custom-select">
												<option @if($category->status == 1) selected @endif value="1">Active</option>
												<option @if($category->status == 0) selected @endif value="0">InActive</option>
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

                        successMsg('Update Category', data.msg);

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Create Category','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Update Category', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });

          
    </script>
@stop