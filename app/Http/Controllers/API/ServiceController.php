<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;
use Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::orderBy('id', 'asc')->get();
        return response()->json(['status'=>'success', 'message'=>'successfully received selected services data', 'data'=>$services], 200);
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
            'service_name' =>'required',
            'service_description' =>'required',
        ]);
        if ($validator->fails()){
            return response()->json(['status' => 'fail', 'message'=>$validator->errors()->first()],401);
        }
        $service = Service::create([
            'service_name' => $request->service_name,
            'service_description' => $request->service_description,
        ]);
        return response()->json(['status'=>'success','message'=>'service successfully registered'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $services = Service::find($id);
        return response()->json(['status'=>'success', 'message'=>'successfully received selected package data', 'data'=>$services], 200);
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
            'service_name' =>'required',
            'service_description' =>'required',
        ]);
        if ($validator->fails()){
            return response()->json(['status' => 'fail', 'message'=>$validator->errors()->first()],401);
        }
        Service::find($id)->update([
            'service_name' => $request->service_name,
            'service_description' => $request->service_description,
        ]);
        return response()->json(['status'=>'success','message'=>'service successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service::find($id)->delete();
        return response()->json(['status'=>'success','message'=>'service successfully deleted'], 200);
    }
}
