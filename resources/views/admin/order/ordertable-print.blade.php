@extends('admin/layouts/default')
@section('title')
<title>Restaurant-Dashboard</title>
@stop
@section('inlinecss')
<style>
#global-loader{
    display:none !important; 
} 
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
</style>
@stop
@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        <div class="page-header">
        <button type="button" class="btn btn-sm btn-primary no-print" onclick="print()">Print</button>
        </div>
        <!-- ROW-1 OPEN -->
        <div class="col-12" id="printDiv">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                        
                        {{$order->table->table_no}} Table Orders</h3>
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
                          </tr>
                      </thead>
                      <tbody>
					  @php $totoal = 0 @endphp
					   @php $billAmount = 0 @endphp
					@foreach($order->item_list as $item)

                    @if($item->delivery_status == 'Cancel') return continue @endif

					@php $itemtotal = $item->price*$item->quantity @endphp
					@php $billAmount = $billAmount+$itemtotal @endphp
					@php $totoal = $totoal+$itemtotal @endphp
					<tr>
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
                   
						<i class="fa fa-inr" aria-hidden="true"></i> <span class="item-amount">{{$itemtotal}}</span>
                        
						</td>
                        
						</td>
					</tr>
					

					@endforeach
                      </tbody>
					  <tfoot>
                          <tr>
                              <th colspan="3" class="text-right">Bill Amount</th>
                              <th><i class="fa fa-inr" aria-hidden="true"></i> <span id="bill-amount">{{$totoal}}</span></th>
                              
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
<script type="text/javascript">
        $(function () {
            window.print();
        });
 </script>
@stop