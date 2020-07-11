<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<title>Food Menu</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
  $(".addnumber span").click(function(){
    $(".opencartlist").addClass("showcart");
  });
});

$(document).ready(function(){
  $(document).on('click', '.closecart', function(){
    $(".opencartlist").removeClass("showcart");
  });
});



$(document).ready(function(){
  $(".logo").click(function(){
    $(".placecartlist").addClass("showcart");
  });
});
</script>

</head>

<body>
<div class="main">
	
<header>

<div class="col-md-6 col-sm-6 col-xs-6 no-pad float-left logorespo">
<div class="logo"><a href="#"><img src="{{ asset('front/img/logo.png') }}" alt="logo"></img></a></div>
</div>

<div class="col-md-6 col-sm-6 col-xs-6 no-pad float-right heratrespo">
<div class="heartarea"><a href="#"><img src="{{ asset('front/img/heart.png') }}" alt="heart"></img></a></div>
</div>
<div class="clearfix"></div>

</header>

<div class="contentbody">
@foreach($restaurant->category as $cat)
<div class="rollsarea">
<h2>{{$cat->category_title}}</h2><span>({{count($cat->menu)}} Items)</span>

@foreach($cat->menu as $menu)
<div class="foodlist">
<ul>
<li class="greenTag"><span><span></span></span></li>
<li class="text">
<a href="#">{{$menu->title}}</a>
<p>{{$menu->description}}</p>
<span><i class="fa fa-inr" aria-hidden="true"></i>{{$menu->price->price}}</span></li>
<li class="addnumber"><span><a class="cartform" href="javascript:void(0)" data-id="{{$menu->id}}">Add +</a></span> <br><p>Customize</p></li>
</ul>
@endforeach
</div>

@endforeach

</div>



</div>


<div class="opencartlist">

</div>


<div class="placecartlist">

<div class="orderbox">
<ul>
<li><span>Order by</span><h2>9876 543 210</h2></li>
<li><button>Add More Items</button></li>
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
<ul>
<li class="greenTag"> <span><span></span></span></li>
<li>Mix Veg Noodles (Half)<p>Addon option : Red Sauce</p></li>
<li class="cartmore"><ul>
<li><span><a href="#"><i class="fa fa-minus" aria-hidden="true"></i></a></span></li>
<li><input type="text" alt="" name="" class="cartnumber"></li>
<li><span><a href="#"><i class="fa fa-plus" aria-hidden="true"></i></a></span></li>
</ul><p><i class="fa fa-inr" aria-hidden="true"></i> 60.00</p></li>
</ul>
<ul>
<li class="greenTag"> <span><span></span></span></li>
<li>Mix Veg Noodles<p>Addon option : Red Sauce</p></li>
<li class="cartmore"><ul>
<li><span><a href="#"><i class="fa fa-minus" aria-hidden="true"></i></a></span></li>
<li><input type="text" alt="" name="" class="cartnumber"></li>
<li><span><a href="#"><i class="fa fa-plus" aria-hidden="true"></i></a></span></li>
</ul><p><i class="fa fa-inr" aria-hidden="true"></i> 80.00</p></li>
</ul>
</div>

</div>


<div class="cartbuttonarea">
<div class="itemnumber">
<span>5 Items</span>
<h2><i class="fa fa-inr" aria-hidden="true"></i> 80</h2>
</div>

<div class="placecart">
<p><a href="#">Place Order</a></p>
</div>


</div>

</div>
<script>
$(document).ready(function(){
$('.cartform').click(function(){
	menuid = $(this).data('id');
	$('.opencartlist').html('<p>Loading.......</p>');
	$.ajax({
		url: '{{route('cart-form', '')}}/'+menuid,
		type: 'GET', 
		success: function(data){
			$('.opencartlist').html(data.html);
		}
	});
});
});
</script>
</body>
</html>
