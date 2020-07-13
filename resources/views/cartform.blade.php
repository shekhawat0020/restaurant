
<form action="{{route('cart-order')}}" id="productForm">
{{csrf_field()}}
<input type="hidden" name="table_id" value="{{$table_id}}">
<div class="cartpadding">

<div class="topheadcart">
<div class="col-md-12 col-sm-12 col-xs-12 no-pad float-left">
<div class="foodtype">

<ul>
<li><span></span>
<h2>{{$menu->title}}</h2></li>
<li><p><a href="#" class="closecart"><i class="fa fa-times" aria-hidden="true"></i></a>
</p></li>

</ul>

</div>
</div>


</div>

<div class="bottomcart">
<h3>Add Option</h3>
@foreach($menu->price_list as $key=>$price)
<ul>
<li><input type="radio" class="product_name" name="product" value="{{$price->id}}" @if($key==0) checked @endif data-price="{{$price->price}}"></li>
<li>{{$price->price_title}}</li>
<li><i class="fa fa-inr" aria-hidden="true"></i> {{$price->price}}</li>
</ul>
@endforeach
</div>

</div>


<div class="cartbuttonarea">
<div class="cartnum">
<ul>
<li><span><a href="javascript:void(0)" id="lessitem"><i class="fa fa-minus" aria-hidden="true"></i></a></span></li>
<li><input type="number" value="1" min="1" alt="" name="product_qantity" id="product_qantity" class="cartnumber"></li>
<li><span><a href="javascript:void(0)" id="additem"><i class="fa fa-plus" aria-hidden="true"></i></a></span></li>
</ul>
</div>

<div class="addcart">
<p><button id="formButton" type="submit">Add <i class="fa fa-inr" aria-hidden="true"></i> <span class="totalAmount">{{$menu->price->price}}</span></button></p>
</div>


</div>
			
	
</form>