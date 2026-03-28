<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Penerimaan Barang</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-box-seam me-2"></i>Penerimaan Barang (BPB)
                    </h5>

                    <button class="px-4 shadow-sm btn btn-primary fw-bold rounded-3" type="button"
                        onclick="window.location.href='{{ route('BpbMstr.create') }}'">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Penerimaan
                    </button>
                </div>

                <div class="card-body">
                    <div class="mb-4 ux-filter-area">
                        <form action="{{ route('BpbMstr.index') }}" method="GET" class="row g-3 align-items-end">
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
                                <a href="{{ route('BpbMstr.index') }}"
                                    class="px-4 btn btn-light ms-2 rounded-3 text-muted">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="BpbTable" class="table table-ux">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th>Info BPB</th>
                                    <th>Referensi Dokumen</th>
                                    <th>Supplier & Gudang</th>
                                    <th>Remark</th>
                                    <th>User</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bpb as $item)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text text-primary">{{ $item->bpb_mstr_nbr }}</span>
                                            <span class="ux-sub-text">Tgl:
                                                {{ \Carbon\Carbon::parse($item->bpb_mstr_date)->format('d/m/Y') }}</span>
                                        </td>
                                        <td>
                                            <div class="small" style="line-height: 1.3">
                                                <span class="d-block"><strong class="ux-sub-text">Faktur:</strong>
                                                    {{ $item->bpb_mstr_nofaktur }}</span>
                                                <span class="d-block"><strong class="ux-sub-text">SJ:</strong>
                                                    {{ $item->bpb_mstr_nosj }}</span>
                                                <span class="d-block text-success"><strong
                                                        class="ux-sub-text">PO:</strong>
                                                    {{ $item->po->po_mstr_nbr ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="ux-main-text">{{ $item->supplier->supp_mstr_name ?? '-' }}</span>
                                            <span class="mt-1 border badge bg-light text-secondary fw-normal">
                                                <i
                                                    class="bi bi-geo-alt me-1"></i>{{ $item->location->loc_mstr_name ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="ux-sub-text small text-truncate d-block"
                                                style="max-width: 150px;" title="{{ $item->bpb_mstr_note }}">
                                                {{ $item->bpb_mstr_note ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="ux-sub-text small text-uppercase">{{ $item->user->user_mstr_name }}</span>
                                            <span
                                                class="x-small d-block text-muted">{{ $item->bpb_mstr_createdat }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="gap-1 d-flex justify-content-center">
                                                <button class="btn-ux-action btn-view"
                                                    onclick="window.open('{{ route('BpbMstr.show', $item->bpb_mstr_id) }}')"
                                                    title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <a href="{{ route('PrMstr.create', $item->bpb_mstr_id) }}"
                                                    class="btn-ux-action btn-edit" style="--ux-color: #6c757d"
                                                    title="Retur">
                                                    <i class="bi bi-cart-dash"></i>
                                                </a>

                                                <button class="btn-ux-action btn-edit"
                                                    onclick="window.open('{{ route('BpbMstr.edit', $item->bpb_mstr_id) }}')"
                                                    title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <form action="{{ route('BpbMstr.destroy', $item->bpb_mstr_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn-ux-action btn-delete"
                                                        onclick="confirmDelete('{{ $item->bpb_mstr_id }}')"
                                                        title="Hapus">
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
            $("#BpbTable").DataTable({
                scrollX: true, // Wajib untuk tabel lebar seperti ini
                scrollY: "350px",
                scrollCollapse: true,
                autoWidth: false, // MATIKAN agar kita bisa kontrol via CSS
                paging: true,

            });
        </script>
        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Hapus BPB?',
                    text: "Hutang terkait (jika belum dibayar) akan ikut terhapus dan stok akan ditarik!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-delete-' + id).submit();
                    }
                })
            }
            $(document).ready(function() {
                // Mengaktifkan semua tooltip di halaman
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            });
        </script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
    @endpush
</x-app-layout>
