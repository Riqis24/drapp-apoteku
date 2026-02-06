<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductPlacement;
use App\Http\Requests\StoreProductPlacementRequest;
use App\Http\Requests\UpdateProductPlacementRequest;
use App\Models\ProductMeasurements;

class ProductPlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $placements = ProductPlacement::orderBy('code')->get();
        return view('master.ProductPlacementList', compact('placements'));
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
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:product_placements',
            'name' => 'required'
        ]);

        ProductPlacement::create($request->only('code', 'name', 'description'));

        return back()->with('success', 'Placement added');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductPlacement $productPlacement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductPlacement $productPlacement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);

        $check = ProductMeasurements::where('placement_id', $id)->first();
        if ($check) {
            return redirect()->back()->with('error', 'Lokasi Sudah Digunakan di Product Measurements, Tidak Bisa Diubah!');
        }

        $placement = ProductPlacement::findOrFail($id);
        $placement->update([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Data updated successfully!');
    }

    public function destroy($id)
    {
        $check = ProductMeasurements::where('placement_id', $id)->first();
        if ($check) {
            return redirect()->back()->with('error', 'Lokasi Sudah Digunakan di Product Measurements, Tidak Bisa Diubah!');
        }
        $placement = ProductPlacement::findOrFail($id);
        $placement->delete();

        return redirect()->back()->with('success', 'Data deleted successfully!');
    }
}
