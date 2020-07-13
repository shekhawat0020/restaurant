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
<style>
.alert-messages-box {
    position: fixed;
    right: 0;
    top: 0;
    width: 399px;
    z-index: 9999;
}
</style>

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


</div>

<div class="alert-messages-box">
        
    </div>
<script>
$(document).ready(function(){
$('.cartform').click(function(){
	menuid = $(this).data('id');
	$('.opencartlist').html('<p>Loading.......</p>');
	$.ajax({
		url: '{{URL::to("/ajax/get-cart-form")}}/'+{{$table_id}}+'/'+menuid,
		type: 'GET', 
		success: function(data){
			$('.opencartlist').html(data.html);
		}
	});
});


$(".logo").click(function(){
    $(".placecartlist").addClass("showcart");
	
	$('.placecartlist').html('<p>Loading.......</p>');
	$.ajax({
		url: '{{URL::to("/ajax/my-order")}}/'+{{$table_id}},
		type: 'GET', 
		success: function(data){
			$('.placecartlist').html(data.html);
		}
	});
 });



$(document).on('click','#additem',function(){
	$('#product_qantity').val(parseInt($('#product_qantity').val())+1);
	calculateAmount();
});

$(document).on('click','#lessitem',function(){
	if(parseInt($('#product_qantity').val())> 1){
	$('#product_qantity').val(parseInt($('#product_qantity').val())-1);
	}
	calculateAmount();
});

$(document).on('click', '.product_name', function(){
	calculateAmount();
});



$(document).on('submit','#productForm',function(){	
            var $this = $('#formButton');
            buttonLoading('loading', $this);
            $.ajax({
                url: $(document).find('#productForm').attr('action'),
                type: "POST",
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: new FormData($(document).find('#productForm')[0]),
                success: function(data) {
                    if(data.status){

                        successMsg('Place Order', 'Order successfully Placed...');
						$(".opencartlist").removeClass("showcart");

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
							   errorMsg('Place Order',msg);
                            });
                        });
                        
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Server Error', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
        });

});

function calculateAmount(){
	prodcut_price = $(document).find("input[name='product']:checked").data('price');
	total = parseInt($('#product_qantity').val())*parseInt(prodcut_price);
	$('.totalAmount').html(total);
}

function buttonLoading(processType, ele){
        if(processType == 'loading'){
            ele.html(ele.attr('data-loading-text'));
            ele.attr('disabled', true);
        }else{
            ele.html(ele.attr('data-rest-text'));
            ele.attr('disabled', false);
        }
    }

    function successMsg(heading,message, html = ""){
        box = $('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>'+heading+'</strong><hr class="message-inner-separator"><p>'+message+'</p>'+html+'</div>');
        $('.alert-messages-box').append(box);
    }
    function errorMsg(heading,message){
        box = $('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>'+heading+'</strong><hr class="message-inner-separator"><p>'+message+'</p></div>');
        $('.alert-messages-box').append(box);
    }
</script>
</body>
</html>
