<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParchaseStoreRequest;
use App\Http\Requests\ParchaseUpdateRequest;
use App\Models\Drug;
use App\Models\Parshase;
use App\Models\ParshaseDrug;
use Illuminate\Http\Request;

class ParchaseController extends Controller
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
        $parchases= Parshase::orderBy('created_at', 'desc')->get();
        return response()->json($parchases);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParchaseStoreRequest $request)
    {
        $lastparchase = Parshase::create([
            'supplier_name' => $request->suppliername,
            'total' => $request->total,
        ]);
        foreach($request->items as $item){
            $drug = Drug::firstWhere('name', $item['name']);
            if($drug){
                $avilablesunit =  $drug->avilablesunit + ($drug->packet) * $item['qty'] ;
                $shortstatus=false;
                if($avilablesunit <= $drug->min)
                    $shortstatus=true;
                $drug->update([
                    'disc' => $item['disc'],
                    'avilablesunit' => $avilablesunit,
                    'short' => $shortstatus,
                ]);
            }
            ParshaseDrug::create([
                'parshase_id' => $lastparchase->id,
                'drug_name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'disc' => $item['disc'],
                'total' => $item['qty'] * $item['price'],
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Parshase $parchase)
    {
        //نفذت الفانكشن دي علشان تجيب كل الحاجات اللي تخص الفاتوره دي 
        $parchase->drugs;
        return response()->json($parchase);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParchaseUpdateRequest $request, Parshase $parchase)
    {
        foreach($parchase->drugs as $item){
            $drug = Drug::firstWhere('name', $item['drug_name']);
            if($drug){
                $avilablesunit =  $drug->avilablesunit - ($drug->packet) * $item['qty'] ;
                $shortstatus=false;
                if($avilablesunit <= $drug->min)
                    $shortstatus=true;
                $drug->update([
                    'disc' => $item['disc'],
                    'avilablesunit' => $avilablesunit,
                    'short' => $shortstatus,
                ]);
            }
            $item->delete();
        }

        foreach($request->items as $item){
            $drug = Drug::firstWhere('name', $item['name']);
            if($drug){
                $avilablesunit =  $drug->avilablesunit + ($drug->packet) * $item['qty'] ;
                $shortstatus=false;
                if($avilablesunit <= $drug->min)
                    $shortstatus=true;
                $drug->update([
                    'disc' => $item['disc'],
                    'avilablesunit' => $avilablesunit,
                    'short' => $shortstatus,
                ]);
            }
            ParshaseDrug::create([
                'parshase_id' => $parchase->id,
                'drug_name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'disc' => $item['disc'],
                'total' => $item['qty'] * $item['price'],
            ]);
            
        }
        $parchase->update([
            'supplier_name' => $request->suppliername,
            'total' => $request->total,
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parshase $parchase)
    {
        $parchase->delete();
    }
}
