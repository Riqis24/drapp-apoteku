<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Retur Penjualan</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-arrow-return-left me-2"></i>Daftar Sales Return
                    </h5>
                </div>

                <div class="card-body">
                    <div class="ux-filter-area">
                        <form action="{{ route('SrMstr.index') }}" method="GET" class="row g-3 align-items-end">
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
                                    <i class="bi bi-filter"></i> Apply Filter
                                </button>
                                <a href="{{ route('SrMstr.index') }}"
                                    class="px-4 btn btn-light ms-2 rounded-3 text-muted">Reset</a>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="SrTable" class="table table-ux">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th>Info Return (SR#)</th>
                                    <th class="text-center">Referensi INV#</th>
                                    <th>Alasan Return</th>
                                    <th>Status / Log</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($srs as $sr)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text text-primary">{{ $sr->sr_mstr_nbr }}</span>
                                            <span class="ux-sub-text">
                                                <i
                                                    class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($sr->sr_mstr_date)->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="px-3 border badge bg-light text-dark">
                                                {{ $sr->sales->sales_mstr_nbr }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text small">{{ $sr->sr_mstr_reason }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-sub-text">Created:</span>
                                            <span
                                                class="ux-sub-text fw-medium text-dark">{{ \Carbon\Carbon::parse($sr->created_at)->format('d/m/y H:i') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="gap-2 d-flex justify-content-center">
                                                <a href="{{ route('SrMstr.show', $sr->sr_mstr_id) }}"
                                                    class="btn-ux-action btn-view" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <form id="delete-sr-{{ $sr->sr_mstr_id }}"
                                                    action="{{ route('SrMstr.destroy', $sr->sr_mstr_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-ux-action btn-delete"
                                                        onclick="confirmDeleteSr('{{ $sr->sr_mstr_id }}', '{{ $sr->sr_mstr_nbr }}')"
                                                        title="Delete">
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
            $("#SrTable").DataTable({
                scrollX: true, // Wajib untuk tabel lebar seperti ini
                scrollY: "350px",
                scrollCollapse: true,
                autoWidth: false, // MATIKAN agar kita bisa kontrol via CSS
                paging: true,

            });
        </script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
        <script>
            function confirmDeleteSr(id, srNumber) {
                Swal.fire({
                    title: 'Hapus Sales Return?',
                    text: `Apakah Anda yakin ingin menghapus SR: ${srNumber}? Data tidak dapat dikembalikan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form secara manual
                        document.getElementById('delete-sr-' + id).submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
