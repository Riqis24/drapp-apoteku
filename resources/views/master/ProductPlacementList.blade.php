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
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-box-seam me-2"></i>Penempatan Produk
                    </h5>

                    <button class="px-4 shadow-sm btn btn-primary fw-bold rounded-3" type="button"
                        data-bs-toggle="modal" data-bs-target="#modalAddPlacement">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Lokasi
                    </button>
                </div>

                <div class="card-body">
                    <div class="border-0 table-responsive">
                        <table id="productTable" class="table align-middle table-ux nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th style="width:15%">Kode</th>
                                    <th style="width:20%">Nama Lokasi</th>
                                    <th>Deskripsi / Detail Rak</th>
                                    <th class="text-center" style="width:10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($placements as $item)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <code class="text-primary fw-bold">{{ $item->code }}</code>
                                        </td>
                                        <td>
                                            <span class="ux-main-text fw-bold">{{ $item->name }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-sub-text text-truncate d-inline-block"
                                                style="max-width: 300px;" title="{{ $item->description }}">
                                                {{ $item->description ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="gap-2 d-flex justify-content-center">
                                                <button type="button" class="btn-ux-action btn-edit editBtnPlacement"
                                                    data-id="{{ $item->id }}" data-code="{{ $item->code }}"
                                                    data-name="{{ $item->name }}"
                                                    data-description="{{ $item->description }}" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditPlacement" title="Edit Penempatan">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>

                                                <form action="{{ route('ProductPlacement.destroy', $item->id) }}"
                                                    method="POST" id="delete-form-{{ $item->id }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-ux-action btn-delete"
                                                        onclick="confirmDelete('{{ $item->id }}')"
                                                        title="Hapus Penempatan">
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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
