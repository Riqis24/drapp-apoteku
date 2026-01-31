<?php

namespace App\Http\Controllers;

use App\Models\LocMstr;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLocMstrRequest;
use App\Http\Requests\UpdateLocMstrRequest;

class LocMstrController extends Controller
{
    public function index()
    {
        $locations = LocMstr::orderBy('loc_mstr_name')->get();
        return view('master.LocMstrList', compact('locations'));
    }

    public function create()
    {
        return view('master.LocMstrList');
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'loc_mstr_code'      => 'required|unique:loc_mstr,loc_mstr_code|max:20',
            'loc_mstr_name'      => 'required|max:100',
            'loc_mstr_active'    => 'nullable|boolean',
            'loc_mstr_isvisible' => 'nullable|boolean',
        ]);

        try {
            // 2. Simpan Data
            // Menggunakan $request->merge atau default value jika checkbox tidak tercentang
            LocMstr::create([
                'loc_mstr_code'      => $validated['loc_mstr_code'],
                'loc_mstr_name'      => $validated['loc_mstr_name'],
                'loc_mstr_active'    => $request->boolean('loc_mstr_active'),
                'loc_mstr_isvisible' => $request->boolean('loc_mstr_isvisible'),
            ]);

            return redirect()->route('LocMstr.index')
                ->with('success', 'Gudang berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'loc_mstr_code' => 'required|unique:loc_mstr,loc_mstr_code,' . $id . ',loc_mstr_id',
            'loc_mstr_name' => 'required',
        ]);

        $loc = LocMstr::findOrFail($id);
        $loc->update([
            'loc_mstr_code' => $request->loc_mstr_code,
            'loc_mstr_name' => $request->loc_mstr_name,
            'loc_mstr_isvisible' => $request->loc_mstr_isvisible,
        ]);

        return redirect()->back()->with('success', 'Lokasi berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Cek jika masih ada stok di lokasi ini sebelum hapus
        $hasStock = \App\Models\stocks::where('loc_id', $id)->where('quantity', '>', 0)->exists();

        if ($hasStock) {
            return redirect()->back()->with('error', 'Gagal! Lokasi ini masih memiliki stok barang.');
        }

        LocMstr::destroy($id);
        return redirect()->back()->with('success', 'Lokasi berhasil dihapus');
    }

    // public function destroy($id)
    // {
    //     $location = LocMstr::findOrFail($id);
    //     $location->delete();

    //     return redirect()->route('loc_mstr.index')->with('success', 'Gudang berhasil dihapus');
    // }
}
