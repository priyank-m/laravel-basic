<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class RegistrationController extends Controller
{
    public function index() {
        return view('auth/registration');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function storeUser(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'name'              =>      'required|string|max:255',
                'email'             =>      'required|string|email|max:255|unique:users',
                'password'          =>      'required|string|min:6',
                'phone'             =>      'required|max:20',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name'              => $request->get('name'),
            'email'             => $request->get('email'),
            'password'          => Hash::make($request->get('password')),
            'phone'             => $request->get('phone'),
        ]);


        $token = JWTAuth::fromUser($user);

        if($token){
            return response()->json(compact('user','token'),201);
        }

        if($user){ 
            $userCredentials = $request->only('email', 'password');
            if (Auth::attempt($userCredentials)) {
                return response()->json(["status"=>true,"redirect_location"=>url("dashboard")]);
            }
        }
    }

    public function getAuthenticatedUser()
        {
                try {

                        if (! $user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json(['user_not_found'], 404);
                        }

                } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                        return response()->json(['token_expired'], $e->getStatusCode());

                } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                        return response()->json(['token_invalid'], $e->getStatusCode());

                } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                        return response()->json(['token_absent'], $e->getStatusCode());

                }

                return response()->json(compact('user'));
        }
}

// class RegistrationController extends Controller
// {
//     public function index() {
//         return view('auth/registration');
//     }

//     public function storeUser(Request $request) {
 
//         $validator = Validator::make($request->all(),  [
//             'name'              =>      'required',
//             'email'             =>      'required|email|unique:users,email',
//             'password'          =>      'required|min:6',
//             'phone'             =>      'required|max:20'
//         ]);
//         if ($validator->fails())  
//         {
//             return response()->json([
//                 'status' => 400,
//                 'errors' => $validator->errors(),
//             ]); 

//         }
        
        
//         $inputArray      =           array(
//             'name'              =>      $request->name,
//             'email'             =>      $request->email,
//             'password'          =>      Hash::make($request->password),
//             'phone'             =>      $request->phone
//         );

//         $user           =           User::create($inputArray);
        
//         if($user){ 
//             $userCredentials = $request->only('email', 'password');
//             if (Auth::attempt($userCredentials)) {
//                 return response()->json(["status"=>true,"redirect_location"=>url("dashboard")]);
//             }
//         }
//     }
// }
