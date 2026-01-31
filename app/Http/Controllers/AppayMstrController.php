<?php

namespace App\Http\Controllers;

use App\Models\ApMstr;
use App\Models\AppayDet;
use App\Models\AppayMstr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreAppayMstrRequest;
use App\Http\Requests\UpdateAppayMstrRequest;
use App\Models\SuppMstr;

class AppayMstrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = SuppMstr::orderBy('supp_mstr_name')->get();

        return view('ap.AppayMstrList', compact('suppliers'));
    }

    public function getApBySupplier($suppid)
    {
        return ApMstr::with('bpbmstr')->where('ap_mstr_suppid', $suppid)
            ->where('ap_mstr_balance', '>', 0)
            ->orderBy('ap_mstr_duedate')
            ->get();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'appay_date'         => 'required|date',
            'suppid'             => 'required|exists:supp_mstr,supp_mstr_id',
            'items'              => 'required|array|min:1',
            'items.*.ap_id'      => 'required|exists:ap_mstr,ap_mstr_id',
            'items.*.pay_amount' => 'required|numeric|min:1',
        ]);

        try {
            $appay = DB::transaction(function () use ($request) {

                // 2. Generate Number (Logika dipisah ke private function agar clean)
                $nbr = $this->generateAppayNumber();

                // 3. Create Master
                $appay = AppayMstr::create([
                    'appay_mstr_nbr'       => $nbr,
                    'appay_mstr_date'      => $request->appay_date,
                    'appay_mstr_suppid'    => $request->suppid,
                    'appay_mstr_method'    => $request->method,
                    'appay_mstr_refno'     => $request->refno,
                    'appay_mstr_note'      => $request->note,
                    'appay_mstr_total'     => 0,
                    'appay_mstr_createdby' => auth()->user()->user_mstr_id,
                ]);

                $totalPayment = 0;

                // 4. Proses Items
                foreach ($request->items as $row) {
                    if ($row['pay_amount'] <= 0) continue;

                    $ap = ApMstr::lockForUpdate()->findOrFail($row['ap_id']);

                    // Validasi Keamanan
                    if ($ap->ap_mstr_suppid != $request->suppid) {
                        throw new \Exception("AP {$ap->ap_mstr_nbr} tidak sesuai dengan Supplier yang dipilih.");
                    }

                    if ($row['pay_amount'] > $ap->ap_mstr_balance) {
                        throw new \Exception("Pembayaran AP {$ap->ap_mstr_nbr} melebihi sisa hutang.");
                    }

                    // Detail Payment
                    AppayDet::create([
                        'appay_det_mstrid'    => $appay->appay_mstr_id,
                        'appay_det_apid'      => $ap->ap_mstr_id,
                        'appay_det_payamount' => $row['pay_amount'],
                    ]);

                    // Update AP Master
                    $ap->ap_mstr_paid    += $row['pay_amount'];
                    $ap->ap_mstr_balance -= $row['pay_amount'];
                    $ap->ap_mstr_status   = $ap->ap_mstr_balance <= 0 ? 'paid' : 'partial';
                    $ap->save();

                    $totalPayment += $row['pay_amount'];
                }

                // 5. Final Total Update
                $appay->update(['appay_mstr_total' => $totalPayment]);

                return $appay;
            });

            return redirect()->route('ApMstr.index')
                ->with('success', "Pembayaran {$appay->appay_mstr_nbr} berhasil disimpan");
        } catch (\Exception $e) {
            // DI SINI KUNCINYA: Catch error agar Toast muncul
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    /**
     * Helper untuk generate nomor urut
     */
    private function generateAppayNumber()
    {
        $last = AppayMstr::orderByDesc('appay_mstr_id')->first();
        $next = 1;

        if ($last && preg_match('/APPAY-(\d+)/', $last->appay_mstr_nbr, $m)) {
            $next = (int)$m[1] + 1;
        }

        return 'APPAY-' . str_pad($next, 5, '0', STR_PAD_LEFT);
    }
    /**
     * Display the specified resource.
     */
    public function show(AppayMstr $appayMstr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppayMstr $appayMstr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppayMstrRequest $request, AppayMstr $appayMstr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 1. Cari Master Pembayarannya
        $payMstr = AppayMstr::where('appay_mstr_id', $id)->firstOrFail();

        // 2. Ambil semua detail hutang yang dibayar dalam transaksi ini
        $details = AppayDet::where('appay_det_mstrid', $id)->get();
        // dd($payMstr);
        try {
            DB::beginTransaction();

            foreach ($details as $det) {
                // 3. Ambil Master Hutang terkait
                $ap = DB::table('ap_mstr')->where('ap_mstr_id', $det->appay_det_apid)->first();
                if ($ap) {
                    // 4. Hitung nilai baru
                    $newPaid = $ap->ap_mstr_paid - $det->appay_det_payamount;
                    $newBalance = $ap->ap_mstr_amount - $newPaid;
                    $newStatus = ($newPaid <= 0) ? 'unpaid' : 'partial';
                    // dd($ap);

                    // 5. Update menggunakan Query Builder (Tanpa $ap->save())
                    DB::table('ap_mstr')
                        ->where('ap_mstr_id', $det->appay_det_apid)
                        ->update([
                            'ap_mstr_paid'    => $newPaid,
                            'ap_mstr_balance' => $newBalance,
                            'ap_mstr_status'  => $newStatus,
                        ]);
                }

                // 6. Hapus detail pembayaran
                $det->delete();
            }


            // 7. Terakhir hapus master pembayarannya
            $payMstr->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Transaksi pembayaran berhasil dibatalkan. Saldo hutang supplier telah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membatalkan pembayaran: ' . $e->getMessage());
        }
    }
}
