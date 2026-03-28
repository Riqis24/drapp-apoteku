<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Master Satuan</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-rulers me-2"></i>Master Satuan
                    </h5>

                    <button class="px-4 shadow-sm btn btn-primary fw-bold rounded-3" type="button"
                        data-bs-toggle="modal" data-bs-target="#modalAddMeasurement">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Satuan
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="measurementTable" class="table table-ux">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:10%">No</th>
                                    <th>Nama Satuan</th>
                                    <th class="text-center" style="width:15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($measurements as $measurement)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text fw-bold">{{ $measurement->name }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="gap-2 d-flex justify-content-center">
                                                <button type="button" class="btn-ux-action btn-edit editBtn"
                                                    data-id="{{ $measurement->id }}"
                                                    data-name="{{ $measurement->name }}" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditMeasurement" title="Edit Satuan">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>

                                                <form action="{{ route('MeasurementMstr.destroy', $measurement->id) }}"
                                                    method="POST" id="delete-form-{{ $measurement->id }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-ux-action btn-delete"
                                                        onclick="confirmDelete('{{ $measurement->id }}')"
                                                        title="Hapus Satuan">
                                                        <i class="bi bi-trash3-fill"></i>
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
                <div class="py-3 bg-white border-0 card-footer">
                </div>
            </div>
        </div>
    </div>

    {{-- modal add user --}}
    <form action="{{ route('MeasurementMstr.store') }}" method="POST">
        @csrf
        <div class="modal fade" id="modalAddMeasurement" tabindex="-1" aria-labelledby="modalAddMeasurementLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddMeasurementLabel">Role Master</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="dynamicMeasurementsInputs">
                            <div class="measurement-row">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" class="form-control form-control-sm" name="measurements[]"
                                            placeholder="Contoh: Pieces" required>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button"
                                            class="rounded btn btn-danger btn-sm removeRow">❌</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info" id="addRow">Add Row</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="modalEditMeasurement" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Satuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" id="edit_meas_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="{{ 'assets/js/MeasurementMstr/getData.js' }}"></script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
        <script>
            // --- LOGIC EDIT MODAL ---
            $(document).on('click', '.editBtn', function() {
                let id = $(this).data('id');
                let name = $(this).data('name'); // Ambil data dari attribute button

                // Isi value input di modal
                $('#edit_meas_name').val(name);

                // Ubah action form secara dinamis
                let url = "{{ route('MeasurementMstr.update', ':id') }}";
                url = url.replace(':id', id);
                $('#editForm').attr('action', url);
            });

            // --- LOGIC DELETE SWEETALERT ---
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form hapus yang sesuai ID
                        document.getElementById('delete-form-' + id).submit();
                    }
                })
            }
        </script>
    @endpush
</x-app-layout>
