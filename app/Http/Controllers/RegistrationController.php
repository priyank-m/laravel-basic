<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegistrationController extends Controller
{
    public function index() {
        return view('auth/registration');
    }

    public function storeUser(Request $request) {
 
        $validator = Validator::make($request->all(),  [
            'name'              =>      'required',
            'email'             =>      'required|email|unique:users,email',
            'password'          =>      'required|min:6',
            'phone'             =>      'required|max:20'
        ]);
        if ($validator->fails())  
        {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]); 

        }
        
        
        $inputArray      =           array(
            'name'              =>      $request->name,
            'email'             =>      $request->email,
            'password'          =>      Hash::make($request->password),
            'phone'             =>      $request->phone
        );

        $user           =           User::create($inputArray);
        
        if($user){ 
            $userCredentials = $request->only('email', 'password');
            if (Auth::attempt($userCredentials)) {
                return response()->json(["status"=>true,"redirect_location"=>url("dashboard")]);
            }
        }
    }
}
