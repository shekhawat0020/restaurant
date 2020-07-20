<form action="{{route('cart-order')}}" id="placeOrder">
{{csrf_field()}}
<input type="hidden" name="table_id" value="{{$table_id}}">
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

        @php $total = 0 @endphp
        @if($cart)
        @foreach($cart as $key => $item)

            @php $itemtotal = $item['price']*$item['quantity'] @endphp
            @php $total = $total+$itemtotal @endphp
           
            <ul id="row-{{$key}}">
            
            <li class="@if($item['type']) greenTag @else redTag @endif"><span><span></span></span></li>
            <li>{{$item['name']}}<p>Addon option : {{$item['price_list_name']}}</p>
            <p><a href="javascript:void(0)" class="removecart" data-id="{{$key}}">Remove</a></p></li>
            <li class="cartmore">
                <ul>
                <li><span><a href="javascript:void(0)" class="lessnumber"><i class="fa fa-minus" aria-hidden="true"></i></a></span></li>
                <li>
                <input type="hidden" name="product[]" value="{{$key}}">
                <input type="hidden" name="unit_price[]" class="unit_price" value="{{$item['price']}}">    
                <input type="text" alt="" name="product_qantity[]" class="cartnumber" value="{{$item['quantity']}}">
                </li>
                <li><span><a href="javascript:void(0)"  class="addnumber"><i class="fa fa-plus" aria-hidden="true"></i></a></span></li>
                </ul>
            <p><i class="fa fa-inr" aria-hidden="true"></i><span class="itemtotal"> {{$itemtotal}}</span></p></li>
            </ul>
        @endforeach
        @else
            <p>Cart is Empty !</p>
        @endif


    </div>

</div>


<div class="cartbuttonarea">
    <div class="itemnumber">
    @if($cart)
        <span class="countitem">{{count($cart)}}</span>
    @endif
        <h2><i class="fa fa-inr" aria-hidden="true"></i> <span class="carttotal">{{$total}}</span></h2>
    </div>

    <div class="placecart">
        <p><button id="cartformButton" type="submit">Place Order</button></p>
    </div>


</div>
</form>
