<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class logincontroller extends Controller
{
    public function login() {
          
        return view('auth/login');
    }

    public function checkLogin(Request $request) {


        $validator = Validator::make($request->all(),  [
            'email'             =>      'required|email',
            'password'          =>      'required|min:6',
        ]);

        if ($validator->fails())  
        {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]); 

        }else{

        $userCredentials = $request->only('email', 'password');

        if (Auth::attempt($userCredentials)) {
            return response()->json(["status"=>true,"redirect_location"=>url("dashboard")]);
        }

        else {
            $arr = array('msg' => 'Whoops! invalid username or password.', 'status' => false);
        }
        return Response()->json($arr);
    }
    }

    public function logout(Request $request ) {
        $request->session()->flush();
        Auth::logout();
        return Redirect('/');
        }
}
