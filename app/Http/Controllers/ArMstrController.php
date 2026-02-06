<?php

namespace App\Http\Controllers;

use App\Models\ArMstr;
use App\Http\Requests\StoreArMstrRequest;
use App\Http\Requests\UpdateArMstrRequest;
use Illuminate\Http\Request;

class ArMstrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ArMstr::with('customer');
        $query->when($request->start_date, function ($q) use ($request) {
            return $q->whereDate('created_at', '>=', $request->start_date);
        });

        $query->when($request->end_date, function ($q) use ($request) {
            return $q->whereDate('created_at', '<=', $request->end_date);
        });

        $ars = $query->get();

        return view('ar.ArMstrList', compact('ars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArMstrRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ArMstr $arMstr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArMstr $arMstr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArMstrRequest $request, ArMstr $arMstr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArMstr $arMstr)
    {
        //
    }
}
