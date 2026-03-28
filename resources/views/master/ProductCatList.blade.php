<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Product Category Master</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-tags me-2"></i>Kategori Produk
                    </h5>

                    <button class="px-4 shadow-sm btn btn-primary fw-bold rounded-3" type="button"
                        onclick="openAddModal()">
                        <i class="bi bi-plus-lg me-2"></i>Add Category
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="productTable" class="table table-ux">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:8%">No</th>
                                    <th style="width:30%">Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center" style="width:15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $item)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text fw-bold text-dark">
                                                {{ $item->product_cat_name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="ux-sub-text">
                                                {{ $item->product_cat_desc ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="gap-2 d-flex justify-content-center">
                                                <button class="btn-ux-action btn-edit"
                                                    onclick="editCategory({{ $item->product_cat_id }}, '{{ $item->product_cat_name }}', '{{ $item->product_cat_desc }}')"
                                                    title="Edit Kategori">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>

                                                <button class="btn-ux-action btn-delete"
                                                    onclick="deleteCategory({{ $item->product_cat_id }})"
                                                    title="Hapus Kategori">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
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

    {{-- Modal Add/Edit (Single Form) --}}
    <div class="modal fade" id="modalCategory" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="categoryForm" action="{{ route('ProductCat.store') }}" method="POST">
                    @csrf
                    <div id="methodField"></div>
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTitle">Add Product Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="product_cat_name" id="input_name"
                                    required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="product_cat_desc" id="input_desc" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ 'assets/js/ProductMstr/getData.js' }}"></script>
        <script>
            const modalElement = new bootstrap.Modal(document.getElementById('modalCategory'));
            const form = document.getElementById('categoryForm');
            const modalTitle = document.getElementById('modalTitle');
            const methodField = document.getElementById('methodField');

            // Fungsi Tambah Baru
            function openAddModal() {
                modalTitle.innerText = "Add Product Category";
                form.action = "{{ route('ProductCat.store') }}";
                methodField.innerHTML = ""; // Kosongkan (default POST)
                form.reset();
                modalElement.show();
            }

            // Fungsi Edit
            function editCategory(id, name, desc) {
                modalTitle.innerText = "Edit Product Category";
                // Ubah action form ke route update
                form.action = `/ProductCat/${id}`;
                // Tambahkan spoofing method PUT untuk Laravel
                methodField.innerHTML = `@method('PUT')`;

                // Isi data ke input
                document.getElementById('input_name').value = name;
                document.getElementById('input_desc').value = desc;

                modalElement.show();
            }

            // Fungsi Delete (Tetap disarankan pakai Fetch/AJAX agar bisa konfirmasi Swal dulu)
            function deleteCategory(id) {
                Swal.fire({
                    title: 'Hapus Kategori?',
                    text: "Pastikan kategori tidak sedang digunakan oleh produk apapun.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/ProductCat/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json().then(data => ({
                                status: response.status,
                                body: data
                            })))
                            .then(res => {
                                if (res.status === 200) {
                                    Swal.fire('Berhasil', res.body.message, 'success').then(() => location
                                        .reload());
                                } else {
                                    Swal.fire('Gagal', res.body.message, 'error');
                                }
                            });
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
