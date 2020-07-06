<?php

namespace App;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    use Userstamps;
    protected $table = 'restaurant_category';


    protected $fillable = [
        'restaurant_id', 'category_title', 'parent_category', 'status'
    ];

    
}
