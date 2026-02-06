<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Pemindahan Barang</h3>
        </div>
        <div class="page-content">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <button class="btn btn-outline-primary btn-sm rounded" type="button"
                                onclick="window.location.href='{{ route('TsMstr.create') }}'">
                                Tambah Pemindahan Barang
                            </button>
                        </div>

                        <div class="flex-grow-1">
                            <form action="{{ route('TsMstr.index') }}" method="GET"
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
                                        <a href="{{ route('TsMstr.index') }}" class="btn btn-sm btn-secondary">
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
                        <table id="TsTable" class="table table-striped table-bordered table-sm nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>TS#</th>
                                    <th>Tanggal</th>
                                    <th>Dari</th>
                                    <th>Ke</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $ts)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ts->ts_mstr_nbr }}</td>
                                        <td>{{ $ts->ts_mstr_date }}</td>
                                        <td>{{ $ts->fromLocation->loc_mstr_name }}</td>
                                        <td>{{ $ts->toLocation->loc_mstr_name }}</td>
                                        <td>{{ strtoupper($ts->ts_mstr_status) }}</td>
                                        <td>
                                            <a href="{{ route('TsMstr.show', $ts->ts_mstr_id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="bi bi-folder"></i>
                                            </a>
                                            <form action="{{ route('TsMstrList.destroy', $ts->ts_mstr_id) }}"
                                                method="POST" class="d-inline" id="delete-form-{{ $ts->ts_mstr_id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="handleDelete('{{ $ts->ts_mstr_id }}')">
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
        {{-- <script src="{{ 'assets/js/ExpenseTr/getData.js' }}"></script> --}}
        <script>
            $("#TsTable").DataTable({
                scrollX: true, // Wajib untuk tabel lebar seperti ini
                scrollY: "350px",
                scrollCollapse: true,
                autoWidth: false, // MATIKAN agar kita bisa kontrol via CSS
                paging: true,

            });
        </script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
        <script>
            function handleDelete(id) {
                // Sesuaikan dengan nama fungsi di swal-helper kamu, biasanya confirmDelete atau sejenisnya
                Swal.fire({
                    title: 'Hapus Draft?',
                    text: "Data Transfer Sheet yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form secara manual berdasarkan ID
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
