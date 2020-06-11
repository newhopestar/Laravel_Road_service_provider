<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $users = User::orderBy('id','asc')->get();
        return view('users.index',['users'=>$users]);
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
        //
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
            'first_name'=>'required',
            'last_name' => 'required',
            'phone_mobile' => 'required',
            'phone_home' => 'required',
            'phone_work' => 'required',
            'type' => 'required',
            'email' => 'required',
            'password' => '',
            'c_password' => 'same:password',
        ]);
        if($request->password!="") {
            User::find($id)->update([
                'first_name' =>$request->first_name,
                'last_name' => $request->last_name,
                'phone_mobile' => $request->phone_mobile,
                'phone_home' => $request->phone_home,
                'phone_work' => $request->phone_work,
                'type' => $request->type,
                'email' => $request->email,
                'password'=> Hash::make($request->password),
            ]);
        } else {
            User::find($id)->update([
                'first_name' =>$request->first_name,
                'last_name' => $request->last_name,
                'phone_mobile' => $request->phone_mobile,
                'phone_home' => $request->phone_home,
                'phone_work' => $request->phone_work,
                'type' => $request->type,
                'email' => $request->email,
            ]);
        }
        return redirect()->back()->with(['message' => 'account successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')->with('success', 'record deleted successfully');
    }

    public function getMyaccount()
    {
        $myAccount = User::get();
        return view('myaccount.index',[ 'myaccount'=>$myAccount]);
    }
}
