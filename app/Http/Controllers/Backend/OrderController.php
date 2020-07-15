<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\Category;
use App\Menu;
use App\Table;
use App\Order;
use App\OrderItem;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;
use PDF;
use File;
use URL;
use QrCode;

class OrderController extends Controller
{
   
 
	
    
    public function index(Request $request)
    {
		$restaurantUserID = Auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $restaurantUserID)->first();
		
		if ($request->ajax()) {
            $data = Table::where('restaurant_id', $restaurant->id)
			->where(function($query){
				$ordertable = Order::where('closing_status', 1)->pluck('table_id');
				$query->whereIn('id', $ordertable);
			})
			->latest()->get();
			
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Restaurant')){
                            $btn .= '<a href="'.route("order-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }
						

                        return $btn;
                    })
                     ->addColumn('total_order',  function ($table) {
						 $order = Order::where('table_id', $table->id)->where('closing_status', 1)->first();
                        return OrderItem::where('order_id', $order->id)->count();
                     })
					  ->addColumn('pending_order',  function ($table) {
						 $order = Order::where('table_id', $table->id)->where('closing_status', 1)->first();
                        return OrderItem::where('order_id', $order->id)->where('delivery_status', 'Process')->count();
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('admin.order.ordertable');
    }
 
 public function tableOrder($table_id){
		$order = Order::where('table_id', $table_id)->where('closing_status', 1)
			 ->with('item_list')
			 ->with('table')
			 ->first();
			 
		return view('admin.order.ordertable-edit', compact('order'));
		
	}


    
}