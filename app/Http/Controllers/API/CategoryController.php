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
            $userId = Auth::id();
            //$status = $data['status'];
            $results = Category::select('*',\DB::raw('CONCAT("'.env('APP_URL').'", categoryImage) as categoryImage'))->where(function ($query) use ($status) {
                if($status != ''){
                    $query->where('categoryStatus',$status);
                }
            })->where('userid',$userId)->orderBy('id', 'desc')->get();

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
        $userId = Auth::id();

        if(is_null($dataid)){
           $validator = Validator::make($request->all(),  [
            'categoryName'              =>      'required|unique:categories',
            'categoryImage'             =>      'required|image|mimes:jpeg,png,jpg,svg',
            ]);
        }else{
            if(!empty($request->categoryImage)){
                $validator = Validator::make($request->all(),  [
                    'categoryName'              =>      'required|unique:categories',
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
                    'code' => 200,
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
        $categories->userId = $userId;
        }else{
            $categories = Category::where('userId',$userId)->find($dataid);
            if(empty($categories)){
                return response()->json(["code"=>200,"message"=>"unauthorized person not allowed"]);
            }else{ 
            $categories->categorySlug = $categoryslugs;
            $categories->userId = $userId;
            }
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
        if($categories){
            return response()->json(["code"=>200,"message"=>"Sucessfully"]);
        }else{
            return response()->json(["code"=>200,"message"=>"Record Not Found"]);
        }
        return response()->json(["code"=>401,"message"=>"unauthorized person not allowed"]);
    }

    public function edit(Request $request){

        //$data = array($request->slug);
        $where = array('id' => $request->id);
        $categoryedit  = Category::where($where)->first();
        if($categoryedit){
            return response()->json(["code"=>200,"data"=>$categoryedit,"message"=>"Record Found"]);
        }else{
            return response()->json(["code"=>200,"message"=>"Record Not Found"]);
        }
        return response()->json(["code"=>401,"message"=>"unauthorized person not allowed"]);

    }

    public function delete(Request $request){

        //$data = array($request->slug);
        $categorydelete = Category::find($request->id); 
        $categorydelete->delete();
        $usersImage = ($categorydelete->categoryImage);
            if(\File::exists($usersImage)){
                unlink($usersImage);
            }

        if ($categorydelete) {
            return response()->json(["code"=>200,"message"=>"Deleted successfully"]);
        }
        else {
            return response()->json(["code"=>200,"message"=>"Whoops! Somting went wrong"]);
        }
        return response()->json(["code"=>401,"message"=>"unauthorized person not allowed"]);

    }

    
}
