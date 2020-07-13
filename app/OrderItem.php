<?php

namespace App;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $table = 'restaurant_order_item';


    protected $fillable = [
        'order_id','price_list_id','product_name','price_list_name','price','delivery_status'
    ];
	
	

    
}
