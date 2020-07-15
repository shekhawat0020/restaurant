@extends('admin/layouts/default')
@section('title')
<title>Restaurant-Dashboard</title>
@stop
@section('inlinecss')

@stop
@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="col-12">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{$order->table->table_no}} Table Orders</h3>
                        <div class="ml-auto pageheader-btn">
                        
								
                           
							</div>
                    </div>
                    <div class="card-body ">
                        
                    <table class="table table-bordered data-table">
                      <thead>
                          <tr>
                              <th>Order Item</th>
                              <th>Order Status</th>
                              <th>Price</th>
                              <th>Quantity</th>
                              <th>Total</th>
                              <th width="100px">Action</th>
                          </tr>
                      </thead>
                      <tbody>
					  @php $totoal = 0 @endphp
					   @php $billAmount = 0 @endphp
					@foreach($order->item_list as $item)
					@php $itemtotal = $item->price*$item->quantity @endphp
					@php $billAmount = $billAmount+$itemtotal @endphp
					@php $totoal = $totoal+$itemtotal @endphp
					<tr>
						<td>
						{{$item->product_name}}<p>Addon option : {{$item->price_list_name}}</p>
						</td>
					
						<td>
						{{$item->delivery_status}}
						</td>
					
						<td>
						<i class="fa fa-inr" aria-hidden="true"></i> {{$item->price}}
						</td>
						
						<td>
						<i class="fa fa-inr" aria-hidden="true"></i> {{$item->quantity}}
						</td>
						
						<td>
						<i class="fa fa-inr" aria-hidden="true"></i> {{$itemtotal}}
						</td>
					
						<td>
						</td>
					</tr>
					

					@endforeach
                      </tbody>
					  <tfoot>
                          <tr>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th>Bill Amount</th>
                              <th><i class="fa fa-inr" aria-hidden="true"></i> {{$billAmount}}</th>
                              <th width="100px"></th>
                          </tr>
                      </tfoot>
                  </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 CLOSED -->
    </div>

 



</div>
@stop
@section('inlinejs')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        
    <script type="text/javascript">
        $(function () {
            

           
            
        });
    </script>
@stop