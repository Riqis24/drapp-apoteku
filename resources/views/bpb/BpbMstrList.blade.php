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
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <button class="btn btn-outline-primary btn-sm rounded" type="button"
                                onclick="window.location.href='{{ route('BpbMstr.create') }}'">
                                Tambah Penerimaan Barang
                            </button>
                        </div>

                        <div class="flex-grow-1">
                            <form action="{{ route('BpbMstr.index') }}" method="GET"
                                class="row g-2 justify-content-md-end align-items-end">
                                <div class="col-6 col-md-3 col-lg-2">
                                    <label class="form-label small mb-1 fw-bold">Dari Tanggal</label>
                                    <input type="date" name="start_date" class="form-control form-control-sm"
                                        value="{{ request('start_date') }}">
                                </div>
                                <div class="col-6 col-md-3 col-lg-2">
                                    <label class="form-label small mb-1 fw-bold">Sampai Tanggal</label>
                                    <input type="date" name="end_date" class="form-control form-control-sm"
                                        value="{{ request('end_date') }}">
                                </div>
                                <div class="col-12 col-md-auto">
                                    <div class="btn-group w-100">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="bi bi-filter"></i> Filter
                                        </button>
                                        <a href="{{ route('BpbMstr.index') }}" class="btn btn-sm btn-secondary">
                                            <i class="bi bi-arrow-clockwise"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="BpbTable" class="table table-striped table-bordered table-sm nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">Tanggal</th>
                                    <th style="text-align: center">No #</th>
                                    <th style="text-align: center">Faktur #</th>
                                    <th style="text-align: center">SJ #</th>
                                    <th style="text-align: center">PO #</th>
                                    <th style="text-align: center">Supplier</th>
                                    <th style="text-align: center">Gudang</th>
                                    <th style="text-align: center">Remark</th>
                                    <th style="text-align: center">Created At</th>
                                    <th style="text-align: center">Created By</th>
                                    <th style="text-align: center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bpb as $item)
                                    <tr>
                                        <td style="text-align:right">{{ $loop->iteration }}</td>
                                        <td style="text-align:center">{{ $item->bpb_mstr_date }}</td>
                                        <td style="text-align:center">{{ $item->bpb_mstr_nbr }}</td>
                                        <td>{{ $item->bpb_mstr_nofaktur }}</td>
                                        <td>{{ $item->bpb_mstr_nosj }}</td>
                                        <td style="text-align:center">{{ $item->po->po_mstr_nbr ?? '-' }}</td>
                                        <td>{{ $item->supplier->supp_mstr_name ?? '-' }}</td>
                                        <td style="text-align:center">{{ $item->location->loc_mstr_name ?? '-' }}</td>
                                        <td>{{ $item->bpb_mstr_note }}</td>
                                        <td>{{ $item->bpb_mstr_createdat }}</td>
                                        <td>{{ $item->user->user_mstr_name }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Lihat Detail BPB"
                                                onclick="window.open('{{ route('BpbMstr.show', $item->bpb_mstr_id) }}')">
                                                <i class="bi bi-folder"></i>
                                            </button>

                                            <a href="{{ route('PrMstr.create', $item->bpb_mstr_id) }}"
                                                class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Buat Purchase Return">
                                                <i class="bi bi-cart-dash"></i>
                                            </a>

                                            <button class="btn btn-sm btn-warning" type="button"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data BPB"
                                                onclick="window.open('{{ route('BpbMstr.edit', $item->bpb_mstr_id) }}')">
                                                <i class="bi bi-pen"></i>
                                            </button>

                                            <form action="{{ route('BpbMstr.destroy', $item->bpb_mstr_id) }}"
                                                method="POST" id="form-delete-{{ $item->bpb_mstr_id }}"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus BPB"
                                                    onclick="confirmDelete('{{ $item->bpb_mstr_id }}')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
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
