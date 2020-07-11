<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\Category;
use App\Menu;
use App\MenuPrice;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;
use PDF;
use File;
use URL;

class MenuController extends Controller
{
   
 
	
    public function index(Request $request)
    {
		$restaurantUserID = Auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $restaurantUserID)->first();
		
		if ($request->ajax()) {
            $data = Menu::where('restaurant_id', $restaurant->id)->with('price')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Restaurant')){
                            $btn .= '<a href="'.route("menu-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        return $btn;
                    })
                     ->addColumn('status',  function ($category) {
                        return ($category->status)?'Active':'InActive';
                     })
					 ->editColumn('category_ids',  function ($data) {
                         if($data->category_ids){
                            $titles =   Category::whereIn('id', json_decode($data->category_ids))->pluck('category_title');
                            return json_decode($titles);
                         }
                       
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('admin.menu.menu');
    }

	
	 public function create()
    {
		$restaurantUserID = Auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $restaurantUserID)->first();
        $category = Category::where('status', 1)->where('restaurant_id', $restaurant->id)->get();
        return view('admin.menu.menu-create',compact('category'));
    }

	
	 public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'category_ids' => 'required',
            'title' => 'required|regex:/^[\pL\s\-]+$/u',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price_title.*' => 'required',
            'price.*' => 'required|numeric',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		$imageName = "";
        if($request->hasFile('image')){
        $imageName = time().'.'.$request->image->extension();   
        $request->image->move(public_path('uploads/menu'), $imageName);
        $imageName = "uploads/menu/".$imageName;
        }
        
		$restaurantUserID = Auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $restaurantUserID)->first();
        
        $menu = new Menu();
        $menu->title = $request->title;
        $menu->restaurant_id = $restaurant->id;
        $menu->category_ids = json_encode($request->category_ids);
        $menu->description = $request->description;
        $menu->image = $imageName;
        $menu->status = $request->status;
		$menu->save();
		
		// add price list
		$price_title = $request->price_title;
		$price = $request->price;
		foreach($price_title as $key=>$title){
			$p = new MenuPrice();
			$p->price_title = $title;
			$p->price = $price[$key];
			$p->menu_id = $menu->id;
			$p->save();
			
		}

        return response()->json([
            'status' => true,
            'msg' => 'Menu created successfully'
			]);

    }
	
	public function edit($id)
    {
        $menu = Menu::where('id',$id)
		->with('price_list')
		->first();
		
		$restaurantUserID = Auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $restaurantUserID)->first();
        $category = Category::where('status', 1)->where('restaurant_id', $restaurant->id)->get();
        
        return view('admin.menu.menu-edit',compact('menu','category'));
    }

	
	 public function update(Request $request, $id)
    {
		
		$validator = Validator::make($request->all(), [
            'category_ids' => 'required',
            'title' => 'required|regex:/^[\pL\s\-]+$/u',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price_title.*' => 'required',
            'price.*' => 'required|numeric',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
		$imageName = "";
        if($request->hasFile('image')){
        $imageName = time().'.'.$request->image->extension();   
        $request->image->move(public_path('uploads/menu'), $imageName);
        $imageName = "uploads/menu/".$imageName;
        }
        
        $menu = Menu::find($id);
        $menu->title = $request->title;
        $menu->category_ids = json_encode($request->category_ids);
        $menu->description = $request->description;
		if($imageName != ""){
        $menu->image = $imageName;
		}
        $menu->status = $request->status;
		$menu->save();
		
		// update price list
		MenuPrice::where('menu_id', $menu->id)->delete();
		$price_title = $request->price_title;
		$price = $request->price;
		foreach($price_title as $key=>$title){
			$p = new MenuPrice();
			$p->price_title = $title;
			$p->price = $price[$key];
			$p->menu_id = $menu->id;
			$p->save();
			
		}

        return response()->json([
            'status' => true,
            'msg' => 'Menu updated successfully'
			]);
		
		
	}



	
    
}