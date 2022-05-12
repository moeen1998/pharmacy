<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Drug;
use App\Models\Order;
use App\Models\OrderDrug;
use Error;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders= Order::orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStoreRequest $request)
    {
        $total = 0;
        $shortstatus = false;
        $avilablesunit = 0;
        $quentaty = 0;
        $price=0;
        $status=false;
        foreach($request->items as $item){
            $drug = Drug::firstWhere('name', $item['name']);
            if($drug && $item['qty'] > 0){
                if($item['unit'] === "Tap"||$item['unit'] === "Bottle"){
                    $quentaty = $item['qty'];
                    $avilablesunit =  $drug->avilablesunit - $quentaty ;
                }
                else if($item['unit']==="Box"){
                    $quentaty = $item['qty'] * $item['packet'];
                    $avilablesunit =  $drug->avilablesunit - $quentaty;
                }
                if($avilablesunit < 0){
                    $status=false;
                    // علشان ميكملش باقي البرنامج وياخد وقت ع الفاضي 
                    return "from foreach first";
                    // انا مش هوقف الفو بس لا انا هوقف البرنامج كله علشان الوقت
                    // break;
                }
                else{
                    $status=true;
                }
            }
        }
        if($status){
            $lastorder = Order::create([
                'user_name' => $request->username,
                'total' => $request->total,
            ]);
            foreach($request->items as $item){
                $drug = Drug::firstWhere('name', $item['name']);
                if($drug && $item['qty'] > 0){
                    if($item['unit'] === "Tap"||$item['unit'] === "Bottle"){
                        $total = ($item['smallprice'] * $item['qty']) - ($item['smallprice'] * $item['qty'] * $item['disc'] / 100);
                        $quentaty = $item['qty'];
                        $price = $item['smallprice'] ;
                        $avilablesunit =  $drug->avilablesunit - $quentaty ;
                    }
                    else if($item['unit']==="Box"){
                        $total = ($item['smallprice'] * $item['qty'] * $item['packet']) - ($item['smallprice'] * $item['packet'] * $item['qty'] * $item['disc'] / 100);
                        $quentaty = $item['qty'] * $item['packet'];
                        $price = $item['smallprice'] * $item['packet'];
                        $avilablesunit =  $drug->avilablesunit - $quentaty;
                    }
                    if($avilablesunit <= $drug->min)
                        $shortstatus=true;
                    $drug->update([
                        'avilablesunit' => $avilablesunit,
                        'short' => $shortstatus,
                    ]);
                    OrderDrug::create([
                        'order_id' => $lastorder->id,
                        'drug_name' => $item['name'],
                        'qty' => $item['qty'],
                        'unit' => $item['unit'],
                        'price' => $price,	
                        'disc' => $item['disc'],
                        'total' => $total,
                    ]);
                }
            }
            return "created";
        }
        //احتاطي كدا كدا مش هيوصلها علشان لو عمل الاوردر دا هيبعت انه عمله ولو لا هيعت لا متعملش 
        return "the amount not enough";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $order->drugs;
        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateRequest $request, Order $order)
    {
        // qty":1,"unit":"Tap",

        $total = 0;
        $shortstatus = false;
        $avilablesunit = 0;
        $quentaty = 0;
        $price=0;
        $status=false;
// to remove the old items from OrderDrug table
        
        foreach($request->items as $item){
            $drug = Drug::firstWhere('name', $item['name']);
            if($drug && $item['qty'] > 0){
                if($item['unit'] === "Tap"||$item['unit'] === "Bottle"){
                    $quentaty = $item['qty'];
                    $avilablesunit =  $drug->avilablesunit - $quentaty ;
                }
                else if($item['unit']==="Box"){
                    $quentaty = $item['qty'] * $item['packet'];
                    $avilablesunit =  $drug->avilablesunit - $quentaty;
                }
                if($avilablesunit < 0){
                    $status=false;
                    // علشان ميكملش باقي البرنامج وياخد وقت ع الفاضي 
                    return "from foreach first";
                    // انا مش هوقف الفو بس لا انا هوقف البرنامج كله علشان الوقت
                    // break;
                }
                else{
                    $status=true;
                }
            }
        }
        if($status){
            foreach($order->drugs as $item){
                $drug = Drug::firstWhere('name', $item['drug_name']);
                if($drug){
                    if($item['unit'] === "Tap"||$item['unit'] === "Bottle"){
                        $quentaty = $item['qty'];
                        $avilablesunit =  $drug->avilablesunit + $quentaty ;
                    }
                    else if($item['unit']==="Box"){
                        $quentaty = $item['qty'] * $drug->packet;
                        $avilablesunit =  $drug->avilablesunit + $quentaty;
                    }
                    $shortstatus=false;
                    if($avilablesunit <= $drug->min)
                        $shortstatus=true;
                    $drug->update([
                        'avilablesunit' => $avilablesunit,
                        'short' => $shortstatus,
                    ]);
                    $item->delete();
                }
            }
            $order->update([
                'user_name' => $request->username,
                'total' => $request->total,
            ]);
            foreach($request->items as $item){
                $drug = Drug::firstWhere('name', $item['name']);
                if($drug && $item['qty'] > 0){
                    if($item['unit'] === "Tap"||$item['unit'] === "Bottle"){
                        $total = ($item['smallprice'] * $item['qty']) - ($item['smallprice'] * $item['qty'] * $item['disc'] / 100);
                        $quentaty = $item['qty'];
                        $price = $item['smallprice'] ;
                        $avilablesunit =  $drug->avilablesunit - $quentaty ;
                    }
                    else if($item['unit']==="Box"){
                        $total = ($item['smallprice'] * $item['qty'] * $item['packet']) - ($item['smallprice'] * $item['packet'] * $item['qty'] * $item['disc'] / 100);
                        $quentaty = $item['qty'] * $item['packet'];
                        $price = $item['smallprice'] * $item['packet'];
                        $avilablesunit =  $drug->avilablesunit - $quentaty;
                    }
                    if($avilablesunit <= $drug->min)
                        $shortstatus=true;
                    $drug->update([
                        'avilablesunit' => $avilablesunit,
                        'short' => $shortstatus,
                    ]);
                    OrderDrug::create([
                        'order_id' => $order->id,
                        'drug_name' => $item['name'],
                        'qty' => $item['qty'],
                        'unit' => $item['unit'],
                        'price' => $price,	
                        'disc' => $item['disc'],
                        'total' => $total,
                    ]);
                }
            }
            return "created";
        }
        //احتاطي كدا كدا مش هيوصلها علشان لو عمل الاوردر دا هيبعت انه عمله ولو لا هيعت لا متعملش 
        return "the amount not enough";
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
    }}
