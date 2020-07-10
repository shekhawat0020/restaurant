<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\Category;
use App\Menu;
use App\Table;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($table_id)
    { 
		$table = Table::find($table_id);
		$restaurant = Restaurant::where('id', $table->restaurant_id)
		->with(['category' => function($query){			
			$query->where('status', 1);
		}])->first();
		
		
			
		 $restaurant->category->map(function($cat){
			 
			 $menu = Menu::where('category_ids', 'like', '%"'.$cat->id.'"%')->where('status', 1)->get();
			 $cat->menu = $menu;
			 return $cat;
			 
		 });
			
		//dd($restaurant);
         return view('restaurant', compact('restaurant'));
    }
}
