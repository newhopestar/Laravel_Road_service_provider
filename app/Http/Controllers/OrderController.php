<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use App\Package;
use Illuminate\Http\Request;

class OrderController extends Controller
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
        $orders = Order::with('user','package')->orderBy('id','asc')->get();
        $packages = Package::get();
        $customers = User::where('type','=','Customer')->get();
        return view('orders.index', ['orders'=>$orders, 'packages'=>$packages, 'users'=>$customers]);
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
            'user_id' => 'required',
            'order_date' => 'required',
            'package_id' => 'required',
            'service_period' => 'required',
            'expiration_date' => 'required',
            'notes' => 'required',
        ]);
        Order::create([
            'user_id' => $request->user_id,
            'order_date' => $request->order_date,
            'package_id' => $request->package_id,
            'service_period' => $request->service_period,
            'expiration_date' => $request->expiration_date,
            'notes' => $request->notes,
        ]);
        return redirect()->back()->with(['message'=>'Record created successcully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::find($id)->delete();
        return redirect()->route('orders.index')->with(['message'=>'Record deleted successcully']);
    }
}
