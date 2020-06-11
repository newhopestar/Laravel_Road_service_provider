<?php

namespace App\Http\Controllers;

use App\Requests;
use App\Vehicle;
use App\Service;
use App\User;
use Illuminate\Http\Request;

class RequestsController extends Controller
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
        $requests = Requests::with('vehicle','service')->orderBy('id','asc')->get();
        $services = Service::get();
        $customers = User::where('type','=','Customer')->get();
        if($requests && count($requests) > 0)
        {
            foreach($requests as $r)
            {
                $s_ids = $r->service_id;
                $servicesArray = array();
                if($s_ids)
                {
                    $s_id_array = explode('|', $s_ids);
                    foreach($s_id_array as $_s_id)
                    {
                        $_service = Service::where('id','=',$_s_id)->first();
                        if($_service)
                        {
                            array_push($servicesArray, $_service);
                        }
                    }
                }
                $r->servicesInfo = $servicesArray;
            }
        }
        return view('requests.index', ['requests'=>$requests, 'services'=>$services, 'customers'=>$customers]);
    }

    public function getVehicle(Request $request)
    {
        $customer_id = $request->customer_id;
        $vehicles = Vehicle::where('user_id', '=', $customer_id)->get();
        return response()->json($vehicles);
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
        $this->validate($request, [
            'request_date' => 'required',
            'vehicle_id' => 'required',
            'service_id' => 'required',
            'notes' => 'required',
            'request_location' => 'required',
        ]);
    
        Requests::create([
            'request_date' => $request->request_date,
            'completed_date' => null,
            'vehicle_id' => $request->vehicle_id,
            'service_id' => implode("|", $request->service_id),
            'notes' => $request->notes,
            'request_location' => $request->request_location,
        ]);
        return redirect()->back()->with(['message' => 'Record created successfully ']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function show(Requests $requests)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function edit(Requests $requests)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'completed_date' => 'required',
        ]);
        Requests::find($id)->update([
            'completed_date' =>$request->completed_date,
        ]);
        return redirect()->back()->with(['message' => 'Completed Date successfully entered']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Requests::find($id)->delete();
        return redirect()->route('requests.index')->with(['message'=> 'record deleted successfully']);
    }
}
