<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Master Pelanggan</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-people-fill me-2"></i>Master Pelanggan
                    </h5>

                    <button class="px-4 shadow-sm btn btn-primary fw-bold rounded-3" type="button"
                        data-bs-toggle="modal" data-bs-target="#modalAddCustomer">
                        <i class="bi bi-person-plus-fill me-2"></i>Tambah Pelanggan
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="custTable" class="table table-ux nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th style="width:20%">Nama Pelanggan</th>
                                    <th>Alamat</th>
                                    <th style="width:15%">No. HP</th>
                                    <th class="text-center" style="width:10%">Tipe</th>
                                    <th class="text-center" style="width:10%">Status</th>
                                    <th class="text-center" style="width:10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $cust)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text fw-bold">{{ $cust->name }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-sub-text small text-wrap"
                                                style="max-width: 250px; display: block;">
                                                {{ $cust->address ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cust->phone) }}"
                                                target="_blank" class="text-decoration-none ux-main-text">
                                                <i class="bi bi-whatsapp text-success me-1"></i>{{ $cust->phone }}
                                            </a>
                                        </td>
                                        <td class="text-center text-uppercase small fw-bold text-secondary">
                                            {{ $cust->type }}
                                        </td>
                                        <td class="text-center">
                                            @if ($cust->isvisible == 1)
                                                <span
                                                    class="px-3 badge rounded-pill bg-success-light text-success border-success">
                                                    <i class="bi bi-eye-fill me-1"></i>Active
                                                </span>
                                            @else
                                                <span class="px-3 border badge rounded-pill bg-light text-muted">
                                                    <i class="bi bi-eye-slash-fill me-1"></i>Hidden
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="gap-2 d-flex justify-content-center">
                                                <button type="button" class="btn-ux-action btn-edit editBtnCust"
                                                    data-id="{{ $cust->id }}" data-name="{{ $cust->name }}"
                                                    data-address="{{ $cust->address }}" data-phone="{{ $cust->phone }}"
                                                    data-type="{{ $cust->type }}"
                                                    data-isvisible="{{ $cust->isvisible }}" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditCustomer" title="Edit Pelanggan">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>

                                                <form action="{{ route('CustMstr.destroy', $cust->id) }}"
                                                    method="POST" id="delete-form-{{ $cust->id }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-ux-action btn-delete"
                                                        onclick="confirmDelete('{{ $cust->id }}')"
                                                        title="Hapus Pelanggan">
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
    <form action="{{ route('CustMstr.store') }}" method="POST">
        @csrf
        <div class="modal fade" id="modalAddCustomer" tabindex="-1" aria-labelledby="modalAddCustomerLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddCustomerLabel">Cust Master</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="dynamicCustsInputs">
                            <div class="cust-row">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control form-control-sm" name="name"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="address" class="form-label">Alamat</label>
                                        <input type="text" class="form-control form-control-sm" name="address"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="phone" class="form-label">No HP</label>
                                        <input type="text" class="form-control form-control-sm" name="phone"
                                            required>
                                    </div>
                                    {{-- <div class="col-md-2">
                                        <label for="outstanding" class="form-label">Piutang</label>
                                        <input type="text" class="form-control form-control-sm" value="0"
                                            name="outstandings[]" required>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <label for="type" class="form-label">Type</label>
                                        <select name="type" id="type" class="form-select form-select-sm"
                                            required>
                                            <option value=""></option>
                                            <option value="reguler">Reguler</option>
                                            <option value="member">member</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="isvisible" class="form-label">Visible?</label>
                                        <select name="isvisible" id="isvisible" class="form-select form-select-sm"
                                            required>
                                            <option value="1">Iya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>
                                    {{-- <div class="col-md-1">
                                        <label for="" class="form-label">Remove</label>
                                        <button type="button"
                                            class="rounded btn btn-danger btn-sm removeRow">❌</button>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        {{-- <button type="button" class="btn btn-info" id="addRow">Add Row</button> --}}
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="modalEditCustomer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editCustForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control form-control-sm" name="name"
                                    id="edit_cust_name" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Alamat</label>
                                <input type="text" class="form-control form-control-sm" name="address"
                                    id="edit_cust_address" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">No HP</label>
                                <input type="text" class="form-control form-control-sm" name="phone"
                                    id="edit_cust_phone" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Type</label>
                                <select name="type" id="edit_cust_type" class="form-select form-select-sm"
                                    required>
                                    <option value="reguler">Reguler</option>
                                    <option value="member">Member</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Visible?</label>
                                <select name="isvisible" id="edit_cust_visible" class="form-select form-select-sm"
                                    required>
                                    <option value="1">Iya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Customer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    @push('scripts')
        <script src="{{ 'assets/js/CustMstr/getData.js' }}"></script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
        <script>
            // Logic Modal Edit Customer
            $(document).on('click', '.editBtnCust', function() {
                // Ambil data dari attributes
                let id = $(this).data('id');
                let name = $(this).data('name');
                let address = $(this).data('address');
                let phone = $(this).data('phone');
                let type = $(this).data('type');
                let visible = $(this).data('isvisible');

                // Isi form modal
                $('#edit_cust_name').val(name);
                $('#edit_cust_address').val(address);
                $('#edit_cust_phone').val(phone);
                $('#edit_cust_type').val(type);
                $('#edit_cust_visible').val(visible);

                // Set Action URL
                let url = "{{ route('CustMstr.update', ':id') }}";
                url = url.replace(':id', id);
                $('#editCustForm').attr('action', url);
            });

            // SweetAlert Delete
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Hapus Customer?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
