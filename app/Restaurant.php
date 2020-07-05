<?php

namespace App;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    use Userstamps;
    protected $table = 'restaurant_profile';


    protected $fillable = [
        'user_id', 'name', 'address', 'city', 'state', 'banner_image', 'mobile'
    ];

    
}
