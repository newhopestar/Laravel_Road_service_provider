<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth; 
use Validator;

class AuthController extends Controller
{
    public $successStatus = 200;
    public function register(Request $request) {
        $validator = Validator::make($request->all(),
                    [
                        'first_name'=> 'required',
                        'last_name' => 'required',
                        'email' => 'required|email',
                        'password' => 'required',
                        'c_password' => 'required|same:password',
                    ]);
        if($validator->fails()) {
            return response()->json(['status' => 'fail', 'message'=>$validator->errors()->first()],401);
        }
        $request['password'] = bcrypt($request['password']);
        $user = User::create(
            [
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'phone_mobile' => $request['phone_mobile'],
                'phone_home' => $request['phone_home'],
                'phone_work' => $request['phone_work'],
                'type' => $request['type'],
                'email' => $request['email'],
                'password' => $request['password']
            ]
        );
        $success['token'] = $user->createToken('road_service_provider')->accessToken;
        return response()->json(['status'=>'success','message'=>'successfully registered'], $this->successStatus);
    }

    public function login() {
        if(Auth::attempt(['email'=>request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('road_service_provider')->accessToken;
            $success['user_details'] = $user;
            return response()->json(['status' => 'success', 'message' => 'successfully logged in','data'=>$success], $this->successStatus);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'login failed'], 401);
        }
    }

    public function getUser() {
        $user =  Auth::user();
        return response()->json(['status' =>'success','message'=>'successfully received user data','data'=>$user], $this->successStatus);
    }
}


