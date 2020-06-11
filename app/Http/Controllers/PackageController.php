<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Package;

class PackageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::orderBy('id', 'asc')->get();
        return view('packages.index', ['packages' =>$packages] );
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
        $this->validate($request,[
            'package_name' =>'required',
            'package_cost' =>'required',
            'package_description' =>'required',
        ]);
        Package::create([
            'package_name' => $request->package_name,
            'package_cost' => $request->package_cost,
            'package_description' => $request->package_description,
        ]);
        return redirect()->back()->with('success', 'Record created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $this->validate($request,[
            'package_name' =>'required',
            'package_cost' =>'required',
            'package_description' =>'required',
        ]);
        $requestData = $request->all();
        Package::find($id)->update([
            'package_name' => $request->package_name,
            'package_cost' => $request->package_cost,
            'package_description' => $request->package_description,
        ]);
        return redirect()->back()->with('success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Package::find($id)->delete();
        return redirect()->route('packages.index')->with('success', 'record delected successfully');
    }
}
