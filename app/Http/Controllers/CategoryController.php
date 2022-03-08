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

    public function storeCategory(Request $request) {
 


        $validator = Validator::make($request->all(),  [
            'categoryName'              =>      'required',
            'categoryImage'             =>      'required|image|mimes:jpeg,png,jpg,svg',
        ]);
        if ($validator->fails())  
        {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]); 

        }
        
        $categorystatuscheck = $request->categoryStatus == 'on' ? 1 : 0;
        $stringspcermv = str_replace(' ', '', $request->categoryName);
        $stringlower = strtolower($stringspcermv);
        $randomgnrt= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"),0,4);
        $categoryslugs = $stringlower . '' . $randomgnrt;

        $inputArray      =           array(
            'categoryName'              =>      $request->categoryName,
            'categoryImage'             =>      $request->categoryImage->move('backend/assets/img/category'),
            'categoryStatus'            =>      $categorystatuscheck,
            'categorySlug'              =>      $categoryslugs,
        );

        
//         $categories = new Category();
//         $categories->categoryName = $request->categoryName;
//   //      $categories->categoryImage = $request->categoryImage->move('backend/assets/img/category');
//         $categories->categoryStatus = $categorystatuscheck;
//         $categories->categorySlug = $categoryslugs;
//         $categories->save();

        $category           =           Category::create($inputArray);

        if ($category) {
            return response()->json(["status"=>true,"redirect_location"=>url("category")]);
        }

        else {
            $arr = array('msg' => 'Whoops! Somting went wrong.', 'status' => false);
        }
        return Response()->json($arr);
    }

    public function edit($id){
        
    }
}
