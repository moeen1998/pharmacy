<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicienStoreRequest;
use App\Http\Requests\MedicienUpdateRequest;
use App\Models\Drug;

class MedicienController extends Controller
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
        $drugs= Drug::orderBy('name', 'asc')->get();;
        return response()->json($drugs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicienStoreRequest $request)
    {
        $short=false;
        if($request->avilablesunit <= $request->min)
            $short= true;
        Drug::create([
            'name' => $request->name,
            'type' => $request->type,
            'disc' => $request->disc,
            'avilablesunit' => $request->avilablesunit,
            'smallprice' => $request->smallprice,
            'packet' => $request->packet,
            'min' => $request->min,
            'short' => $short,
            'place_name' => $request->place_name,
            'category_name' => $request->category_name,
        ]);
    return response(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Drug $drug)
    {
        return response()->json($drug);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MedicienUpdateRequest $request, Drug $drug)
    {
        $short=false;
        if($request->avilablesunit<=$request->min)
            $short=true;
        $drug->update([
            'name' => $request->name,
            'type' => $request->type,
            'disc' => $request->disc,
            'avilablesunit' => $request->avilablesunit,
            'smallprice' => $request->smallprice,
            'packet' => $request->packet,
            'min' => $request->min,
            'short' => $short,
            'place_name' => $request->place_name,
            'category_name' => $request->category_name,
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drug $drug)
    {
        $drug->delete();
    }
}
