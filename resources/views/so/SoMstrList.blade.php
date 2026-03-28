<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Stock Opname</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-clipboard-check me-2"></i>Stock Opname
                    </h5>

                    <button class="px-4 shadow-sm btn btn-primary fw-bold rounded-3" type="button"
                        onclick="window.location.href='{{ route('SoMstr.create') }}'">
                        <i class="bi bi-plus-lg me-2"></i>Create Stock Opname
                    </button>
                </div>

                <div class="card-body">
                    <div class="mb-4 ux-filter-area">
                        <form action="{{ route('SoMstr.index') }}" method="GET" class="row g-3 align-items-end">
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
                                <a href="{{ route('SoMstr.index') }}"
                                    class="px-4 btn btn-light ms-2 rounded-3 text-muted">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="SoTable" class="table table-ux">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th>No. Opname (SO#)</th>
                                    <th class="text-center">Tanggal</th>
                                    <th>Lokasi / Gudang</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($opnames as $so)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text text-primary">{{ $so->so_mstr_nbr }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="ux-main-text">{{ \Carbon\Carbon::parse($so->so_mstr_date)->format('d/m/Y') }}</span>
                                        </td>
                                        <td>
                                            <span class="border badge bg-light text-secondary fw-normal">
                                                <i
                                                    class="bi bi-geo-alt me-1"></i>{{ $so->location->loc_mstr_name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $status = strtolower($so->so_mstr_status);
                                                $badgeClass =
                                                    $status == 'approved' ? 'bg-success' : 'bg-warning text-dark';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} rounded-pill px-3">
                                                {{ strtoupper($status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="gap-2 d-flex justify-content-center">
                                                <button class="btn-ux-action btn-view"
                                                    onclick="window.location.href='{{ route('SoMstr.edit', $so->so_mstr_id) }}'"
                                                    title="Edit/Detail">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                @if ($status !== 'approved')
                                                    <button class="btn-ux-action btn-success-light text-success"
                                                        onclick="window.location.href='{{ route('SoMstr.viewApprove', $so->so_mstr_id) }}'"
                                                        title="Approve">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </button>
                                                @endif

                                                <form action="{{ route('SoMstr.destroy', $so->so_mstr_id) }}"
                                                    method="POST" class="d-inline"
                                                    id="delete-form-{{ $so->so_mstr_id }}">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn-ux-action btn-delete"
                                                        onclick="handleDelete('{{ $so->so_mstr_id }}')" title="Hapus">
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
            $("#SoTable").DataTable({
                scrollX: true, // Wajib untuk tabel lebar seperti ini
                scrollY: "350px",
                scrollCollapse: true,
                autoWidth: false, // MATIKAN agar kita bisa kontrol via CSS
                paging: true,

            });
        </script>
        <script src="{{ url('assets/js/alert.js') }}"></script>
        <script>
            function handleDelete(id) {
                // Sesuaikan dengan nama fungsi di swal-helper kamu, biasanya confirmDelete atau sejenisnya
                Swal.fire({
                    title: 'Hapus SO?',
                    text: "Data Stock Opname yang dihapus tidak dapat dikembalikan!",
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
