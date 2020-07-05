<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Restaurant;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;
use PDF;
use File;
use URL;

class RestaurantController extends Controller
{
   
 
	
    public function index()
    {
		$restaurantUserID = Auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $restaurantUserID)->first();
		if(!isset($restaurant->id)){
			$restaurant = new Restaurant();
			$restaurant->user_id = $restaurantUserID;
			$restaurant->save();
		}
        
        return view('admin.restaurant.restaurant-profile',compact('restaurant'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		$restaurantUserID = Auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $restaurantUserID)->first();

        $validator = Validator::make($request->all(), [
			'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'banner_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'mobile' => 'required|min:10|unique:restaurant_profile,mobile,'.$restaurant->id,
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
		$imageName = "";
        if($request->hasFile('banner_image')){
        $imageName = time().'.'.$request->banner_image->extension();   
        $request->banner_image->move(public_path('uploads/banner'), $imageName);
        $imageName = "uploads/banner/".$imageName;
        }
        
        $restaurant = Restaurant::find($restaurant->id);
        $restaurant->name = $request->name;
        $restaurant->address = $request->address;
        $restaurant->city = $request->city;
        $restaurant->state = $request->state;
		if($imageName != ""){
        $restaurant->banner_image = $imageName;
        }
        
        $restaurant->mobile = $request->mobile;
        $restaurant->save();
        

        return response()->json([
            'status' => true,
            'msg' => 'Restaurant updated successfully'
			]);

    }



    
}