<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Vehicle;
use Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $current_id = auth()->user()->id;
        $vehicles = Vehicle::where('user_id', '=', $current_id)->get();
        return response()->json(['status'=>'success', 'message'=>'successfully received current user vehicles data', 'data'=>$vehicles], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' =>'required',
            'color' =>'required',
            'license_plate' => 'required',
        ]);
        if ($validator->fails()){
            return response()->json(['status' => 'fail', 'message'=>$validator->errors()->first()],401);
        }
        $vehicle = Vehicle::create([
            'user_id' => auth()->user()->id,
            'type' => $request->type,
            'color' => $request->color,
            'license_plate' => $request->license_plate,
        ]);
        return response()->json(['status'=>'success','message'=>'vechicle successfully registered'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $vehicle = Vehicle::find($id);
        return response()->json(['status'=>'success', 'message'=>'successfully received selected vehicle data', 'data'=>$vehicle], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'type' =>'required',
            'color' =>'required',
            'license_plate' => 'required',
        ]);
        if ($validator->fails()){
            return response()->json(['status' => 'fail', 'message'=>$validator->errors()->first()],401);
        }
        Vehicle::find($id)->update([
            'user_id' => auth()->user()->id,
            'type' => $request->type,
            'color' => $request->color,
            'license_plate' => $request->license_plate,
        ]);
        return response()->json(['status'=>'success','message'=>'vehicle successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Vehicle::find($id)->delete();
        return response()->json(['status'=>'success','message'=>'vehicle successfully deleted'], 200);
    }
}
