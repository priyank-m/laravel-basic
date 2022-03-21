<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Product;
use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Traits\SlugTrait;

class ProductController extends Controller
{

    use SlugTrait;

    public function index(Request $request) {
        if(Auth::check()) {
            $status =  $request->s != '' ? $request->s : '';
            $category =  $request->c!= '' ? $request->c : '';
            $data['status'] = $status;
            $data['category'] = $category;
            $data['results'] = Product::join('categories','products.categoryId','=','categories.id')
            ->where(function ($query) use ($status,$category) {
                if($status != ''){
                    $query->where('products.productStatus',$status);
                }if($category != ''){
                    $query->where('products.categoryId',$category);
                }
            })
            ->select('products.*','categories.categoryName')
            ->orderBy('products.id', 'desc')->get();
            $data['categories'] = Category::where('categoryStatus', 1)->orderBy('id', 'desc')->get();
            $data['categoriesfilters'] = Product::join('categories','products.categoryId','=','categories.id')->select('products.categoryId','categories.categoryName')->distinct()->get();
             return view('product', $data);
            //  print_r($results);
            //  exit();
        }
        return redirect("/")->with('success', 'Logout successfully');;
    }

    public function storeProduct(Request $request) {
 
        $dataid = $request->id;
        $dataImage = $request->productImage;
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
                    'status' => 400,
                    'errors' => $validator->errors(),
                ]); 
            }
 
        $productstatuscheck = $request->productStatus == 'on' ? 1 : 0;
        // $stringspcermv = str_replace(' ', '', $request->productName);
        // $stringlower = strtolower($stringspcermv);
        // $randomgnrt= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"),0,4);
        $productslugs = $this->verifyAndStoreSlug(array('name'=>$request->productName));
  
        if(is_null($dataid)){
        $products = new product();
        $products->productSlug = $productslugs;
        }else{
            $products = product::find($dataid); 
            // return view('product', $products);
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
            return response()->json(["status"=>true,"redirect_location"=>url("product")]);
        }

        else {
            $arr = array('msg' => 'Whoops! Somting went wrong.', 'status' => false);
        }
        return Response()->json($arr);  
    }

    public function edit(Request $request){

        //$data = array($request->slug);
        $where = array('id' => $request->id);
        $productedit  = Product::where($where)->first();

        return \Response::json($productedit);

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
            return response()->json(["status"=>true,"redirect_location"=>url("product")]);
        }
        else {
            $arr = array('msg' => 'Whoops! Somting went wrong.', 'status' => false);
        }
        return Response()->json($arr);

    }


    
}
