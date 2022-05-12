<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Order;
use App\Models\Parshase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class RootController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $drugs = Drug::count();  
        $orders = Order::where('created_at', 'like', "%". date('Y-m-d') ."%")->count();  
        $totalorders = Order::where('created_at', 'like', "%". date('Y-m-d') ."%")->sum('total');  
        $parchases = Parshase::where('created_at', 'like', "%". date('Y-m-d') ."%")->count();  
        $totalparchases = Parshase::where('created_at', 'like', "%". date('Y-m-d') ."%")->sum('total');  
        $short = Drug::where('short', '=', true)->count(); 
        $shortdrugs = Drug::where('short', '=', true)->get(); 

        $count=[
            "drugs"=>$drugs,
            "orders"=>$orders,
            "totalorders"=>$totalorders,
            "parchases"=>$parchases,
            "totalparchases"=>$totalparchases,
            "short"=>$short,
            "shortdrugs"=>$shortdrugs
        ];
        return response()->json($count);
    }
}
