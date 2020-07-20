<div class="orderbox">
<ul>
<li><span>Order by</span><h2>9876 543 210</h2></li>
<li><button type="button" id="add-more-item">Add More Items</button></li>
</ul>
</div>

<div class="cartpadding">

<div class="topheadcart">
<div class="col-md-12 col-sm-12 col-xs-12 no-pad float-left">

<div class="foodinstruction">
<ul>
<li><h2>Add Instructions</h2><p>Any special instructions you want to share with restaurant.</p>
</li>

</ul>

</div>
</div>


</div>

<div class="customcart">
@php $totoal = 0 @endphp
@if(isset($order->item_list))
@foreach($order->item_list as $item)
@php $itemtotal = $item->price*$item->quantity @endphp
@php $totoal = $totoal+$itemtotal @endphp
<ul>
<li class="@if($item->type) greenTag @else redTag @endif"><span><span></span></span></li>
<li>{{$item->product_name}}<p>Addon option : {{$item->price_list_name}}</p></li>
<li class="cartmore">
<p><i class="fa fa-inr" aria-hidden="true"></i> {{$itemtotal}} = {{$item->price}}*{{$item->quantity}}</p></li>
</ul>

@endforeach
@else
<p>No order found !</p>
@endif

</div>

</div>


<div class="cartbuttonarea">

<div class="itemnumber">


</div>

<div class="placecart">
<p><a href="#">Total <i class="fa fa-inr" aria-hidden="true"></i> {{$totoal}}</a></p>
</div>




</div>
