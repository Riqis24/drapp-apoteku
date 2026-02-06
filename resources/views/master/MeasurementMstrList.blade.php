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
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-outline-primary btn-sm rounded" type="button" data-bs-toggle="modal"
                        data-bs-target="#modalAddMeasurement">
                        Tambah Satuan
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="measurementTable" class="table table-striped table-bordered table-sm nowrap"
                            style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width:5%; text-align: center">No</th>
                                    <th style="text-align: center">Nama</th>
                                    {{-- <th>Role</th> --}}
                                    {{-- <th>Status</th> --}}
                                    <th style="width:5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($measurements as $measurement)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $measurement->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning editBtn"
                                                data-id="{{ $measurement->id }}" data-name="{{ $measurement->name }}"
                                                data-bs-toggle="modal" data-bs-target="#modalEditMeasurement">
                                                <i class="bi bi-pen" style="font-size: 12px"></i>
                                            </button>

                                            <form action="{{ route('MeasurementMstr.destroy', $measurement->id) }}"
                                                method="POST" id="delete-form-{{ $measurement->id }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger deleteBtn"
                                                    onclick="confirmDelete('{{ $measurement->id }}')">
                                                    <i class="bi bi-trash" style="font-size: 12px"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">

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
                                            class="btn btn-danger btn-sm rounded removeRow">❌</button>
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
