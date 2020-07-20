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
                        
                    <table class="table table-bordered data-table" id="printtable">
                      <thead>
                          <tr>
                              <th>Order Item</th>
                              <th>Price</th>
                              <th>Quantity</th>
                              <th>Total</th>
                              <th>Order Status</th>
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
					<tr id="row-{{$item->id}}" 
                        @if($item->delivery_status == 'Deliverd')  
                        style = "background:#13bf60"
                        @elseif($item->delivery_status == 'Cancel')
                        style = "background:#dc5454"
                        @endif>
						<td>
						{{$item->product_name}}<p>Addon option : {{$item->price_list_name}}</p>
						</td>
					
						
					
						<td>
						<i class="fa fa-inr" aria-hidden="true"></i> {{$item->price}}
						</td>
						
						<td>
						<i class="fa fa-inr" aria-hidden="true"></i> {{$item->quantity}}
						</td>
						
						<td>
                        @if($item->delivery_status == 'Cancel')
						<i class="fa fa-inr" aria-hidden="true"></i> -{{$itemtotal}}                      @else
						<i class="fa fa-inr" aria-hidden="true"></i> <span class="item-amount">{{$itemtotal}}</span>
                        @endif
						</td>
                        <td class="delivery_status">
						{{$item->delivery_status}}
						</td>
					
						<td class="action">
                        @if($item->delivery_status == 'Process')

                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-success  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item update-status" data-id="{{$item->id}}" href="javascript:void(0)" data-url="{{route('update-order-item-status', ['item_id' => $item->id, 'status' => 'Deliverd'])}}">Deliverd</a>
                               <a class="dropdown-item update-status"  data-id="{{$item->id}}"  href="javascript:void(0)" data-url="{{route('update-order-item-status', ['item_id' => $item->id, 'status' => 'Cancel'])}}">Cancel</a>
                            </div>
                            </div>

                        @endif
						</td>
					</tr>
					

					@endforeach
                      </tbody>
					  <tfoot>
                          <tr>
                              <th colspan="3" class="text-right">Bill Amount</th>
                              <th><i class="fa fa-inr" aria-hidden="true"></i> <span id="bill-amount">0</span></th>
                              <th colspan="2" class="text-right">
                               <button type="button" class="btn btn-primary completeorder" data-url="{{route('complete-order', $order->id)}}">Complete Order</button>
                               <a href="{{route('print-order', $order->id)}}" target="_blank"  class="btn btn-primary" > Print</a>
                              </th>
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
            counttotal();

            $('.update-status').click(function(){

                url = $(this).data('url');
                id = $(this).data('id');
                $('#row-'+id).css('background', '#b1b1b1');
                $.ajax({
                url: url,
                type: 'GET', 
                success: function(data){
                    if(data.status){
                    if(data.delivery_status == 'Deliverd'){
                    $('#row-'+id).css('background', '#13bf60');
                    }else{
                        $('#row-'+id).css('background', '#dc5454');  
                        $('#row-'+id).find('.item-amount').prepend("-");
                        $('#row-'+id).find('.item-amount').removeClass("item-amount");
                    }
                    $('#row-'+id).find('.delivery_status').text(data.delivery_status);
                    $('#row-'+id).find('.action').html("");
                    counttotal();
                    }
                },
                error: function() {
                    errorMsg('Server Error', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }
            });
            });

            $('.completeorder').click(function(){
                $(this).text('completing.....');
                $button = $(this);
                url = $(this).data('url');
                $.ajax({
                url: url,
                type: 'GET', 
                success: function(data){
                    
                    if(data.status){
                        $button.remove();
                        successMsg('Complete Order',data.msg);
                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
							   errorMsg('Complete Order',msg);
                            });
                        });
                        $button.text('Complete Order');
                        
                    }
                },
                error: function() {
                    errorMsg('Server Error', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }
            });

            });
           
            
        });

        function counttotal(){
            total = 0;
            $('.item-amount').each(function(i,v){
                total = total+parseInt($(this).text());
            });
            $('#bill-amount').text(total);
        }

       
    </script>
@stop