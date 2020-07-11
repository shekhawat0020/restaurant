<?php

namespace App;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    use Userstamps;
    protected $table = 'restaurant_menu';


    protected $fillable = [
        'restaurant_id', 'category_ids', 'title', 'description', 'image', 'price', 'status'
    ];
	
	public function price_list()
    {
        return $this->hasMany('App\MenuPrice', 'menu_id', 'id');
    }
	
	public function price()
    {
        return $this->hasOne('App\MenuPrice', 'menu_id', 'id');
    }

    
}
