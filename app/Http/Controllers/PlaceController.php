<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceStoreRequest;
use App\Http\Requests\PlaceUpdateRequest;
use App\Models\place;
use Illuminate\Http\Request;

class PlaceController extends Controller
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
        $places= place::all();
        return response()->json($places);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlaceStoreRequest $request)
    {
        place::create([
            'place' => $request->place,
        ]);
    return response(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(place $place)
    {
        return response()->json($place);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlaceUpdateRequest $request, place $place)
    {
        $place->update([
            'place' => $request->place,
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(place $place)
    {
        $place->delete();
    }
}
