<?php

namespace App;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $table = 'restaurant_order';


    protected $fillable = [
        'closing_status','table_id'
    ];
	
	public function item_list()
    {
        return $this->hasMany('App\OrderItem', 'order_id', 'id');
    }

    
}
