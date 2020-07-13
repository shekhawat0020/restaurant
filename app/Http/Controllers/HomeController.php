<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\Category;
use App\Menu;
use App\Table;
use App\Order;
use App\OrderItem;
use App\MenuPrice;
use Illuminate\Http\Request;
use Validator;

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
			 
			 $menu = Menu::where('category_ids', 'like', '%"'.$cat->id.'"%')
			 ->with('price_list')
			 ->with('price')
			 ->where('status', 1)->get();
			 $cat->menu = $menu;
			 return $cat;
			 
		 });
			
		//dd($restaurant);
         return view('restaurant', compact('restaurant', 'table_id'));
    }

	
	public function cartForm($table_id,$menu_id){
		$menu = Menu::where('id', $menu_id)
			 ->with('price_list')->first();
		$html = view('cartform', compact('menu','table_id'))->render();
		
		return response()->json([
            'status' => true,
            'html' => $html
			]);
	}
	
	public function cartOrder(Request $request){
		
		$validator = Validator::make($request->all(), [
            'product' => 'required',
            'table_id' => 'required',
            'product_qantity' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		//check order already exist
		$tableOrder = Order::where('table_id', $request->table_id)->where('closing_status', 1)->first();
		
		$order_id = 0;
		
		if(!isset($tableOrder->id)){
			$order = new Order();
			$order->closing_status = 1;
			$order->table_id = $request->table_id;
			$order->save();
			$order_id = $order->id;
		}else{			
			$order_id = $tableOrder->id;
		}
		
		$itemPrice = MenuPrice::find($request->product);
		$itemMenu = Menu::find($itemPrice->menu_id);
		
		$orderItem = new OrderItem();
		$orderItem->order_id = $order_id;
		$orderItem->price_list_id = $itemPrice->id;
		$orderItem->menu_id = $itemMenu->id;
		$orderItem->product_name = $itemMenu->title;
		$orderItem->price_list_name = $itemPrice->price_title;
		$orderItem->quantity = $request->product_qantity;
		$orderItem->price = $itemPrice->price;
		$orderItem->save();
		
		
		
		
		return response()->json([
            'status' => true
			]);
	}

	
	public function myorder($table_id){
		$order = Order::where('table_id', $table_id)->where('closing_status', 1)
			 ->with('item_list')->first();
		$html = view('myorder', compact('order'))->render();
		
		return response()->json([
            'status' => true,
            'html' => $html
			]);
	}
	
	
	}
