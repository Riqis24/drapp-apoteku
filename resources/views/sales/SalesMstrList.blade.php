<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Invoice Penjualan</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-cart-check me-2"></i>Daftar Transaksi Penjualan
                    </h5>
                </div>

                <div class="card-body">
                    <div class="ux-filter-area">
                        <form action="{{ route('SalesMstr.index') }}" method="GET" class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label ux-sub-text fw-bold">DARI TANGGAL</label>
                                <input type="date" name="start_date" class="border-0 shadow-sm form-control"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label ux-sub-text fw-bold">SAMPAI TANGGAL</label>
                                <input type="date" name="end_date" class="border-0 shadow-sm form-control"
                                    value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="px-4 shadow-sm btn btn-primary fw-bold rounded-3">
                                    <i class="bi bi-filter"></i> Apply
                                </button>
                                <a href="{{ route('SalesMstr.index') }}"
                                    class="px-4 btn btn-light ms-2 rounded-3 text-muted">Reset</a>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="SalesTable" class="table table-ux">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th>Info Transaksi</th>
                                    <th class="text-center">Gudang</th>
                                    <th class="text-end">Rincian Biaya</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="ux-main-text text-primary">{{ $transaction->sales_mstr_nbr }}</span>
                                            <span class="ux-sub-text">
                                                {{ \Carbon\Carbon::parse($transaction->sales_mstr_createdat)->format('d M Y') }}
                                                •
                                                {{ \Carbon\Carbon::parse($transaction->sales_mstr_createdat)->format('H:i') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="border badge bg-light text-dark">{{ $transaction->loc->loc_mstr_name }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span
                                                class="ux-amount">{{ rupiah($transaction->sales_mstr_grandtotal) }}</span>
                                            <span class="ux-sub-text text-danger" style="font-size: 0.65rem">
                                                Disc: {{ rupiah($transaction->sales_mstr_discamt) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($transaction->sales_mstr_status == 'Paid')
                                                <span
                                                    class="px-3 badge rounded-pill bg-success-subtle text-success">Paid</span>
                                            @else
                                                <span
                                                    class="px-3 badge rounded-pill bg-warning-subtle text-warning">{{ $transaction->sales_mstr_status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="gap-2 d-flex justify-content-center">
                                                <a href="{{ route('SalesMstr.show', $transaction->sales_mstr_id) }}"
                                                    class="btn-ux-action text-info" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('SrMstr.createe', $transaction->sales_mstr_id) }}"
                                                    class="btn-ux-action text-warning" title="Return">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </a>
                                                @role(['Super Admin'])
                                                    <button type="button" class="btn-ux-action text-danger"
                                                        onclick="confirmDeletePay('{{ $transaction->sales_mstr_id }}', '{{ $transaction->sales_mstr_nbr }}')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endrole
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ url('assets/js/alert.js') }}"></script>
        <script>
            $("#SalesTable").DataTable({
                scrollX: true, // Wajib untuk tabel lebar seperti ini
                scrollY: "350px",
                scrollCollapse: true,
                autoWidth: false, // MATIKAN agar kita bisa kontrol via CSS
                paging: true,

            });
        </script>
        <script>
            function confirmDeletePay(id, nbr) {
                Swal.fire({
                    title: 'Hapus Invoice?',
                    text: `Hapus Invoice ${nbr}? Seluruh transaksi akan direverse.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Batalkan!',
                    cancelButtonText: 'Tutup'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Mengembalikan saldo piutang...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        document.getElementById('delete-sales-' + id).submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
