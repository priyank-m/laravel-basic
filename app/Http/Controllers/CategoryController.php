<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index() {
        if(Auth::check()) {
             $results = Category::all();
             return view('category', compact('results'));
            //  print_r($results);
            //  exit();
        }
        return redirect("/")->with('success', 'Logout successfully');;
    }
}
