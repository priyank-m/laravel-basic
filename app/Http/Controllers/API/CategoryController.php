<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class CategoryController extends Controller
{
    public function index(Request $request) {
       
        if(Auth::check()) {
            $status =  $request->s != '' ? $request->s : '';
        
            //$status = $data['status'];
            $results = Category::where(function ($query) use ($status) {
                if($status != ''){
                    $query->where('categoryStatus',$status);
                }
            })->orderBy('id', 'desc')->get();

            if($results){
                return response()->json(["code"=>200,"data"=>$results,"message"=>"Record Found"]);
            }else{
                return response()->json(["code"=>200,"message"=>"Record Not Found"]);
            }
        }
        return response()->json(["code"=>401,"message"=>"unauthorized person not allowed"]);
    }

    public function storeCategory(Request $request) {
 
        $dataid = $request->id;
        $dataImage = $request->categoryImage;

        if(is_null($dataid)){
           $validator = Validator::make($request->all(),  [
            'categoryName'              =>      'required',
            'categoryImage'             =>      'required|image|mimes:jpeg,png,jpg,svg',
            ]);
        }else{
            if(!empty($request->categoryImage)){
                $validator = Validator::make($request->all(),  [
                    'categoryName'              =>      'required',
                    'categoryImage'             =>      'required|image|mimes:jpeg,png,jpg,svg',
                    ]); 
            }else{
                $validator = Validator::make($request->all(),  [
                    'categoryName'              =>      'required',
                ]);   
            }           
        }
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
        if(is_null($dataid)){
        $categories = new Category();
        $categories->categorySlug = $categoryslugs;
        }else{
            $categories = Category::find($dataid); 
        }
        if(!empty($dataImage)){
            $usersImage = ($categories->categoryImage);
            if(\File::exists($usersImage)){
                unlink($usersImage);
            }
            $categories->categoryImage = $request->categoryImage->move('backend/assets/img/category');
            $categories->categoryName = $request->categoryName;
            $categories->categoryStatus = $categorystatuscheck;       
            $categories->save();  
        }else{
        $categories->categoryName = $request->categoryName;
        $categories->categoryStatus = $categorystatuscheck;       
        $categories->save();        
        }
        if ($categories) {
            return response()->json(["status"=>true,"redirect_location"=>url("category")]);
        }

        else {
            $arr = array('msg' => 'Whoops! Somting went wrong.', 'status' => false);
        }
        return Response()->json($arr);  
    }

    
}
