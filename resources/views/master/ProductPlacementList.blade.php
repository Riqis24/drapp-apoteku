<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Master Lokasi</h3>
        </div>
        <div class="page-content">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-outline-primary btn-sm rounded" type="button" data-bs-toggle="modal"
                        data-bs-target="#modalAddPlacement">
                        Tambah Lokasi
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="productTable" class="table table-striped table-bordered table-sm nowrap"
                            style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width:5%; text-align: center">No</th>
                                    <th style="width:20%; text-align: center">Code</th>
                                    <th style="width:20%; text-align: center">Name</th>
                                    <th style="text-align: center">Description</th>
                                    <th style="width:5%; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($placements as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td style="text-align: center">
                                            <button type="button" class="btn btn-sm btn-warning editBtnPlacement"
                                                data-id="{{ $item->id }}" data-code="{{ $item->code }}"
                                                data-name="{{ $item->name }}"
                                                data-description="{{ $item->description }}" data-bs-toggle="modal"
                                                data-bs-target="#modalEditPlacement">
                                                <i class="bi bi-pen" style="font-size: 12px"></i>
                                            </button>

                                            <form action="{{ route('ProductPlacement.destroy', $item->id) }}"
                                                method="POST" id="delete-form-{{ $item->id }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('{{ $item->id }}')">
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
            </div>
        </div>
    </div>

    {{-- modal add user --}}
    <form action="{{ route('ProductPlacement.store') }}" method="POST">
        @csrf
        <div class="modal fade" id="modalAddPlacement" tabindex="-1" aria-labelledby="modalAddPlacementLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddPlacementLabel">Product Placement Master</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" class="form-control form-control-sm" name="code"
                                    placeholder="Contoh: PP-001" required>
                            </div>
                            <div class="col-md-4">
                                <label for="product" class="form-label">Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Description</label>
                                <input type="text" class="form-control form-control-sm" name="description" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="modalEditPlacement" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editPlacementForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Product Placement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control form-control-sm" name="code"
                                    id="edit_code" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control form-control-sm" name="name"
                                    id="edit_name" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control form-control-sm" name="description"
                                    id="edit_description" required>
                            </div>
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
        <script src="{{ 'assets/js/ProductMstr/getData.js' }}"></script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
        <script>
            // --- Logic Modal Edit ---
            $(document).on('click', '.editBtnPlacement', function() {
                // Ambil data dari tombol yang diklik
                let id = $(this).data('id');
                let code = $(this).data('code');
                let name = $(this).data('name');
                let description = $(this).data('description');

                // Isi field di dalam modal edit
                $('#edit_code').val(code);
                $('#edit_name').val(name);
                $('#edit_description').val(description);

                // Atur URL Action form Update secara dinamis
                let url = "{{ route('ProductPlacement.update', ':id') }}";
                url = url.replace(':id', id);
                $('#editPlacementForm').attr('action', url);
            });

            // --- Logic SweetAlert Delete ---
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data Product Placement akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form berdasarkan ID yang dibuat di tabel
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
