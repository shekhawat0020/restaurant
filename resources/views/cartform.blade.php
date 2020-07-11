

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
@foreach($menu->price_list as $price)
<ul>
<li><input type="radio" name="" alt=""></li>
<li>{{$price->price_title}}</li>
<li><i class="fa fa-inr" aria-hidden="true"></i> {{$price->price}}</li>
</ul>
@endforeach
</div>

</div>


<div class="cartbuttonarea">
<div class="cartnum">
<ul>
<li><span><a href="#"><i class="fa fa-minus" aria-hidden="true"></i></a></span></li>
<li><input type="text" alt="" name="" class="cartnumber"></li>
<li><span><a href="#"><i class="fa fa-plus" aria-hidden="true"></i></a></span></li>
</ul>
</div>

<div class="addcart">
<p><a href="#">Add <i class="fa fa-inr" aria-hidden="true"></i> 0</a></p>
</div>


</div>
			
	
