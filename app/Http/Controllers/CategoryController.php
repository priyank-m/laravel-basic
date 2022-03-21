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
use App\Traits\SlugTrait;

class CategoryController extends Controller
{

    use SlugTrait;

    public function index(Request $request) {
        if(Auth::check()) {
            $status =  $request->s != '' ? $request->s : '';
        
            
            $results = Category::where(function ($query) use ($status) {
                if($status != ''){
                    $query->where('categoryStatus',$status);
                }
            })->get();

             return view('category', compact('results','status'));
            //  print_r($results);
            //  exit();
        }
        return redirect("/")->with('success', 'Logout successfully');
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
        // $stringspcermv = str_replace(' ', '', $request->categoryName);
        // $stringlower = strtolower($stringspcermv);
        // $randomgnrt= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"),0,4);
        $categoryslugs = $this->verifyAndStoreSlug(array('name'=>$request->categoryName));
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

    public function edit(Request $request){

        //$data = array($request->slug);
        $where = array('id' => $request->id);
        $categoryedit  = Category::where($where)->first();

        return \Response::json($categoryedit);

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
            return response()->json(["status"=>true,"redirect_location"=>url("category")]);
        }
        else {
            $arr = array('msg' => 'Whoops! Somting went wrong.', 'status' => false);
        }
        return Response()->json($arr);

    }
}
