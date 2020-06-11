<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Package;
use Validator;

class PackageController extends Controller
{
    public function index()
        {
            $packages = Package::orderBy('id', 'asc')->get();
            return response()->json(['status'=>'success', 'message'=>'successfully received selected package data', 'data'=>$packages], 200);
        }
    public function show($id) {
        $package = Package::find($id);
        return response()->json(['status'=>'success', 'message'=>'successfully received selected package data', 'data'=>$package], 200);
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'package_name' =>'required',
            'package_cost' =>'required|numeric',
            'package_description' =>'required',
        ]);
        if ($validator->fails()){
            return response()->json(['status' => 'fail', 'message'=>$validator->errors()->first()],401);
        }
        $pacakge = Package::create([
            'package_name' => $request->package_name,
            'package_cost' => $request->package_cost,
            'package_description' => $request->package_description,
        ]);
        return response()->json(['status'=>'success','message'=>'package successfully registered'], 200);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'package_name' =>'required',
            'package_cost' =>'required|numeric',
            'package_description' =>'required',
        ]);
        if ($validator->fails()){
            return response()->json(['status' => 'fail', 'message'=>$validator->errors()->first()],401);
        }
        Package::find($id)->update([
            'package_name' => $request->package_name,
            'package_cost' => $request->package_cost,
            'package_description' => $request->package_description,
        ]);
        return response()->json(['status'=>'success','message'=>'package successfully updated'], 200);
    }
    public function destroy($id)
    {
        Package::find($id)->delete();
        return response()->json(['status'=>'success','message'=>'package successfully deleted'], 200);
    }
    
}
