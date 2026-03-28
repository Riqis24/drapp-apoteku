<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Utang Usaha</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-wallet2 me-2"></i>Accounts Payable
                    </h5>

                    <button class="px-4 shadow-sm btn btn-primary fw-bold rounded-3" type="button"
                        onclick="window.open('{{ route('AppayMstr.create') }}', '_blank')">
                        <i class="bi bi-cash-stack me-2"></i>Bayar Hutang (Pay)
                    </button>
                </div>

                <div class="card-body">
                    <div class="mb-4 ux-filter-area">
                        <form action="{{ route('ApMstr.index') }}" method="GET" class="row g-3 align-items-end">
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
                                <a href="{{ route('ApMstr.index') }}"
                                    class="px-4 btn btn-light ms-2 rounded-3 text-muted">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="ApTable" class="table table-ux">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th>No. Tagihan (AP#)</th>
                                    <th>Supplier</th>
                                    <th>Info Tanggal</th>
                                    <th class="text-end">Total Tagihan</th>
                                    <th class="text-end">Sisa Bayar</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aps as $ap)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text text-primary">{{ $ap->ap_mstr_nbr }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text">{{ $ap->supplier->supp_mstr_name }}</span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <span class="d-block text-muted">Inv: {{ $ap->ap_mstr_date }}</span>
                                                <span class="d-block text-danger">Due: {{ $ap->ap_mstr_duedate }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold">
                                            {{ rupiah($ap->ap_mstr_amount) }}
                                        </td>
                                        <td class="text-end">
                                            <span
                                                class="{{ $ap->ap_mstr_balance > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                                                {{ rupiah($ap->ap_mstr_balance) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $status = strtolower($ap->ap_mstr_status);
                                                $badgeClass = match ($status) {
                                                    'paid' => 'bg-success',
                                                    'partial' => 'bg-warning text-dark',
                                                    default => 'bg-danger',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} rounded-pill px-3">
                                                {{ strtoupper($status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn-ux-action btn-view"
                                                onclick="window.location.href='{{ route('ApMstr.show', $ap->ap_mstr_id) }}'"
                                                title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </button>
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
        <script>
            $("#ApTable").DataTable({
                scrollX: true, // Wajib untuk tabel lebar seperti ini
                scrollY: "350px",
                scrollCollapse: true,
                autoWidth: false, // MATIKAN agar kita bisa kontrol via CSS
                paging: true,

            });
        </script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
    @endpush
</x-app-layout>
