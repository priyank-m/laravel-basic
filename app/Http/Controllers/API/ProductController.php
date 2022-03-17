<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Product;
use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ProductController extends Controller
{
        public function index(Request $request) {
            if(Auth::check()) {
                $userId = Auth::id();
                $status =  $request->status != '' ? $request->status : '';
                $category =  $request->c!= '' ? $request->c : '';
                $search =  $request->search!= '' ? $request->search : '';
                $status = $status;
                $category = $category;
                $search = $search;
                $results = Product::join('categories','products.categoryId','=','categories.id')
                ->select('products.*','categories.categoryName',\DB::raw('CONCAT("'.env('APP_URL').'", productImage) as productImage'))
                ->where('products.userId',$userId)
                ->where(function ($query) use ($status,$category) {
                    if($status != ''){
                        $query->where('products.productStatus',$status);
                    }
                    if($category != ''){
                        $query->where('products.categoryId',$category);
                    }
                })
                ->where(function ($searchquery) use ($search) {
                    if($search != ''){
                        $searchquery->where('products.productName', 'like',  '%' . $search .'%')
                        
                        ->orwhere('products.productDescription', 'like',  '%' . $search .'%')
                        ->orwhere('categories.categoryName', 'like',  '%' . $search .'%');
                    }
                })
                ->orderBy('products.id', 'desc')->get();
                
                if($results){
                    return response()->json(["code"=>200,"data"=>$results,"message"=>"Record Found"]);
                }else{
                    return response()->json(["code"=>200,"message"=>"Record Not Found"]);
                }
                
            }
            return response()->json(["code"=>401,"message"=>"unauthorized person not allowed"]);
        }
    
        public function storeProduct(Request $request) {
     
            $dataid = $request->id;
            $dataImage = $request->productImage;
            $userId = Auth::id();

            if(is_null($dataid)){
               $validator = Validator::make($request->all(),  [
                'productName'              =>      'required',
                'categoryId'               =>      'required',
                'productDescription'       =>      'required',
                'productImage'             =>      'required|image|mimes:jpeg,png,jpg,svg',
                ]);
            }else{
                if(!empty($dataImage)){
                    $validator = Validator::make($request->all(),  [
                        'productName'              =>      'required',
                        'categoryId'               =>      'required',
                        'productDescription'       =>      'required',
                        'productImage'             =>      'required|image|mimes:jpeg,png,jpg,svg',
                        ]); 
                }else{
                    $validator = Validator::make($request->all(),  [
                        'productName'              =>      'required',
                        'categoryId'               =>      'required',
                        'productDescription'       =>      'required',
                    ]);   
                }           
            }
            if ($validator->fails())  
                {
                    return response()->json([
                        'status' => 200,
                        'errors' => $validator->errors(),
                    ]); 
                }
     
            $productstatuscheck = $request->productStatus == 'on' ? 1 : 0;
            $stringspcermv = str_replace(' ', '', $request->productName);
            $stringlower = strtolower($stringspcermv);
            $randomgnrt= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"),0,4);
            $productslugs = $stringlower . '' . $randomgnrt;
            if(is_null($dataid)){
            $products = new product();
            $products->productSlug = $productslugs;
            $products->userId = $userId;
            }else{
                $products = product::where('userId',$userId)->find($dataid); 
                if(empty($products)){
                    return response()->json(["code"=>200,"message"=>"unauthorized person not allowed"]);
                }else{ 
                $products->productSlug = $productslugs;
                $products->userId = $userId;
                // return view('product', $products);
                }
            }
            if(!empty($dataImage)){
                $productImages = ($products->productImage);
                if(\File::exists($productImages)){
                    unlink($productImages);
                }
                $products->productImage = $request->productImage->move('backend/assets/img/product');
                $products->productName = $request->productName;
                $products->productDescription = $request->productDescription; 
                $products->categoryId = $request->categoryId;       
                $products->productStatus = $productstatuscheck;
                $products->save();  
            }else{
            $products->productName = $request->productName;
            $products->productStatus = $productstatuscheck;    
            $products->productDescription = $request->productDescription;   
            $products->categoryId = $request->categoryId;     
            $products->save();     
            }
            if ($products) {
                return response()->json(["code"=>200,"message"=>"Sucessfully"]);
            }
            else {
                return response()->json(["code"=>200,"message"=>"Record Not Found"]);
            }
            return response()->json(["code"=>401,"message"=>"unauthorized person not allowed"]);
        }
    
        public function edit(Request $request){
    
            //$data = array($request->slug);
            $where = array('id' => $request->id);
            $productedit  = Product::where($where)->first();
    
            if($productedit){
                return response()->json(["code"=>200,"data"=>$productedit,"message"=>"Record Found"]);
            }else{
                return response()->json(["code"=>200,"message"=>"Record Not Found"]);
            }
            return response()->json(["code"=>401,"message"=>"unauthorized person not allowed"]);
    
    
        }
    
        public function delete(Request $request){
    
            //$data = array($request->slug);
            $productdelete = Product::find($request->id); 
            $productdelete->delete();
            $productImages = ($productdelete->productImage);
                if(\File::exists($productImages)){
                    unlink($productImages);
                }
    
            if ($productdelete) {
                return response()->json(["code"=>200,"message"=>"Deleted successfully"]);
            }
            else {
                return response()->json(["code"=>200,"message"=>"Whoops! Somting went wrong"]);
            }
            return response()->json(["code"=>401,"message"=>"unauthorized person not allowed"]);

    
        }    
    
}
