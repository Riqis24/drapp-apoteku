<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Customer;
use App\Models\SalesMstr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('master.CustMstrList', compact('customers'));
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
            Customer::create([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'type' => $request->type,
                'isvisible' => $request->isvisible,
                'total_outstanding' => $request->outstanding ?? 0,
            ]);
            return redirect()->back()->with('success', 'Customer berhasil ditambahkan!');
        } catch (ValidationException $e) {
            // Laravel akan otomatis redirect back, tapi kalau kamu mau manual:
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (Exception $e) {
            Log::error('Gagal menambahkan Customer', ['error' => $e->getMessage()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan customer.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required',
            'address'   => 'required',
            'phone'     => 'required',
            'type'      => 'required',
            'isvisible' => 'required',
        ]);

        $check = Customer::where('name', $request->name)
            ->where('id', '!=', $id)
            ->first();
        if ($check) {
            return redirect()->back()->with('error', 'Nama Customer sudah digunakan.');
        }

        $cust = Customer::findOrFail($id); // Ganti Customer dengan nama Model Anda
        $cust->update($request->all());

        return redirect()->back()->with('success', 'Data Customer berhasil diperbarui');
    }

    // Delete Data
    public function destroy($id)
    {
        $check = SalesMstr::where('sales_mstr_custid', $id)->first();
        if ($check) {
            return redirect()->back()->with('error', 'Customer gagal dihapus atau masih digunakan di tabel lain.');
        }

        $cust = Customer::findOrFail($id);
        $cust->delete();

        return redirect()->back()->with('success', 'Customer telah dihapus');
    }
}
