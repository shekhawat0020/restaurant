<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\Category;
use App\Menu;
use App\Table;
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

class TableController extends Controller
{
   
 
	
    
    public function index(Request $request)
    {
		$restaurantUserID = Auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $restaurantUserID)->first();
		
		if ($request->ajax()) {
            $data = Table::where('restaurant_id', $restaurant->id)->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Restaurant')){
                            $btn .= '<a href="'.route("table-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }
						if(Auth()->user()->can('Restaurant')){
                            $btn .= ' <a target="_blank" href="'.URL::to("/qr/".$row->id).'" class="edit btn btn-primary btn-sm">QR</a>';
                        }

                        return $btn;
                    })
                     ->addColumn('status',  function ($category) {
                        return ($category->status)?'Active':'InActive';
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('admin.table.table');
    }

	
	 public function create()
    {
        return view('admin.table.table-create',compact(''));
    }

	
	 public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'table_no' => 'required',
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
        
        $table = new Table();
        $table->table_no = $request->table_no;
        $table->restaurant_id = $restaurantUserID;
        $table->status = $request->status;
		$table->save();
		
		//create qr
		//QrCode::size(300)->format('png')->generate(URL::to('open-restaurant/'.$table->id), public_path('uploads/qr/qr-'.$table->id.'.png'));

        return response()->json([
            'status' => true,
            'msg' => 'Table created successfully'
			]);

    }
	
	public function QR($id){
		return \QrCode::size(300)->generate(URL::to('open-restaurant/'.$id));
	}
	
	public function edit($id)
    {
        $table = Table::find($id);
        
        return view('admin.table.table-edit',compact('table'));
    }

	
	 public function update(Request $request, $id)
    {
		
		$validator = Validator::make($request->all(), [
            'table_no' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
		
        
        $table = Table::find($id);
        $table->table_no = $request->table_no;
        $table->status = $request->status;
		$table->save();
		
		//create qr
		//QrCode::size(300)->format('png')->generate(URL::to('open-restaurant/'.$table->id), public_path('uploads/qr/qr-'.$table->id.'.png'));

        return response()->json([
            'status' => true,
            'msg' => 'Table updated successfully'
			]);
		
		
	}



    
}