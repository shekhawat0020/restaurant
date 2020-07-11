<?php

namespace App;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;

class MenuPrice extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    use Userstamps;
    protected $table = 'restaurant_menu_price';


    protected $fillable = [
        'menu_id', 'price_title', 'price'
    ];

    
}
