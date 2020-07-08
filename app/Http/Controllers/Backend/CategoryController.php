<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\Category;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;
use PDF;
use File;
use URL;

class CategoryController extends Controller
{
   
 
	
    public function index(Request $request)
    {
		$restaurantUserID = Auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $restaurantUserID)->first();
		
		if ($request->ajax()) {
            $data = Category::where('restaurant_id', $restaurant->id)->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Restaurant')){
                            $btn .= '<a href="'.route("category-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        return $btn;
                    })
                     ->addColumn('status',  function ($category) {
                        return ($category->status)?'Active':'InActive';
                     })
					 ->editColumn('parent_category',  function ($data) {
                         if($data->parent_category){
                            $p =   Category::where('id', $data->parent_category)->first();
                            return $p->category_title;
                         }
                       
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('admin.category.category');
    }

	
	 public function create()
    {
		$restaurantUserID = Auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $restaurantUserID)->first();
        $pCategory = Category::where('parent_category', 0)->where('restaurant_id', $restaurant->id)->where('status', 1)->get();
        return view('admin.category.category-create',compact('pCategory'));
    }

	
	 public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'category_title' => 'required|regex:/^[\pL\s\-]+$/u',
            'parent_category' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
		$restaurantUserID = Auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $restaurantUserID)->first();
        
        $category = new Category();
        $category->category_title = $request->category_title;
        $category->restaurant_id = $restaurant->id;
        $category->parent_category = $request->parent_category;
        $category->status = $request->status;
		$category->save();

        return response()->json([
            'status' => true,
            'msg' => 'Category created successfully'
			]);

    }
	
	public function edit($id)
    {
        $category = Category::find($id);
		
		
		$restaurantUserID = Auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $restaurantUserID)->first();
        $pCategory = Category::where('parent_category', 0)->where('restaurant_id', $restaurant->id)->where('status', 1)->where('id', '!=', $id)->get();
        
        return view('admin.category.category-edit',compact('category','pCategory'));
    }

	
	 public function update(Request $request, $id)
    {
		
		$validator = Validator::make($request->all(), [
            'category_title' => 'required|regex:/^[\pL\s\-]+$/u',
            'parent_category' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        
        $category = Category::find($id);
        $category->category_title = $request->category_title;
        $category->parent_category = $request->parent_category;
        $category->status = $request->status;
		$category->save();

        return response()->json([
            'status' => true,
            'msg' => 'Category updated successfully'
			]);
		
		
	}



    
}