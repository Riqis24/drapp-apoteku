<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Purchase Return</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-arrow-return-left me-2"></i>Purchase Return
                    </h5>
                </div>

                <div class="card-body">
                    <div class="mb-4 ux-filter-area">
                        <form action="{{ route('PrMstr.index') }}" method="GET" class="row g-3 align-items-end">
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
                                <a href="{{ route('PrMstr.index') }}"
                                    class="px-4 btn btn-light ms-2 rounded-3 text-muted">Reset</a>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="PrTable" class="table table-ux">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th>Info Retur (PR#)</th>
                                    <th>Referensi Dokumen</th>
                                    <th>Alasan Retur</th>
                                    <th>Petugas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($returns as $item)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="ux-main-text text-primary">{{ $item->pr_mstr_nbr ?? '-' }}</span>
                                            <span class="ux-sub-text">Tgl: {{ $item->pr_mstr_date ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <div class="small" style="line-height: 1.3">
                                                <span class="d-block"><strong class="ux-sub-text">PO:</strong>
                                                    {{ $item->po->po_mstr_nbr ?? '-' }}</span>
                                                <span class="d-block"><strong class="ux-sub-text">BPB:</strong>
                                                    {{ $item->bpb->bpb_mstr_nbr ?? '-' }}</span>
                                                <span class="d-block"><strong class="ux-sub-text">Faktur:</strong>
                                                    {{ $item->bpb->bpb_mstr_nofaktur ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="ux-main-text small">{{ $item->pr_mstr_reason ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="ux-main-text small text-uppercase">{{ $item->creator->user_mstr_name ?? '-' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="gap-2 d-flex justify-content-center">
                                                <button class="btn-ux-action btn-view" type="button"
                                                    onclick="window.open('{{ route('PrMstr.show', $item->pr_mstr_id) }}')">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <form action="{{ route('PrMstr.destroy', $item->pr_mstr_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-ux-action btn-delete"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data retur ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
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
        <script>
            $("#PrTable").DataTable({
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
