<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\User;
use App\Product;
use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function dashboard() {
        if(Auth::check()) {
            $data['categorycount'] = Category::select('categoryStatus')->where('categoryStatus',1)->count();
            $data['productcount'] = Product::select('productStatus')->where('productStatus',1)->count();
            $data['graphdata'] = Product::select(
                DB::raw('count(id) as total'),
                DB::raw('MONTH(created_at) as month')
            )
            ->groupBy('month')
            ->get();
            
            $monthTotals = [];

            foreach($data['graphdata'] as $item){
                $monthTotals[$item["month"]] = $item["total"];
            }
            
            $data['chartJSCompat'] = [];
            for($i = 1;$i <= 12;$i++){
                if(isset($monthTotals[$i]))
                    $data['chartJSCompat'][$i] = $monthTotals[$i];
                else
                    $data['chartJSCompat'][$i] = 0;
            }
            $data['test'] = array_values($data['chartJSCompat']);
            

            return view('dashboard', $data);
        }

        return redirect("/")->with('success', 'Logout successfully');;
    }
}
