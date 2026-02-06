<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Measurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreMeasurementRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\UpdateMeasurementRequest;
use App\Models\ProductMeasurements;

class MeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $measurements = Measurement::query()->orderBy('id', 'desc')->get();
        return view('master.MeasurementMstrList', compact('measurements'));
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
        try {
            $request->validate([
                'measurements' => 'required|array',
                'measurements.*' => ['required', 'unique:measurements,name'],
            ]);

            foreach ($request->measurements as $measurement) {
                Measurement::create([
                    'name' => $measurement,
                ]);
            }

            return redirect()->back()->with('success', 'Satuan berhasil ditambahkan!');
        } catch (ValidationException $e) {
            // Laravel akan otomatis redirect back, tapi kalau kamu mau manual:
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (Exception $e) {
            Log::error('Gagal menambahkan Satuan', ['error' => $e->getMessage()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan Satuan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Measurement $measurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Measurement $measurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (Measurement::where('name', $request->name)->where('id', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'Nama satuan sudah digunakan.');
        }

        try {
            $data = Measurement::findOrFail($id);
            $data->update([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $check = ProductMeasurements::where('measurement_id', $id)->first();
        if ($check) {
            return redirect()->back()->with('error', 'Data gagal dihapus atau masih digunakan di tabel lain.');
        }

        try {
            $data = Measurement::findOrFail($id);
            $data->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data gagal dihapus atau masih digunakan di tabel lain.');
        }
    }
}
