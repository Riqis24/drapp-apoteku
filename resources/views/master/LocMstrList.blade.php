<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Master Gudang</h3>
        </div>
        <div class="page-content">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-outline-primary btn-sm rounded" type="button" data-bs-toggle="modal"
                        data-bs-target="#addLocModal">
                        Tambah Gudang
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="custTable" class="table table-striped table-bordered table-sm nowrap"
                            style="width:100%">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Visible</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($locations as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $item->loc_mstr_code }}</td>
                                        <td>{{ $item->loc_mstr_name }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge {{ $item->loc_mstr_isvisible ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $item->loc_mstr_isvisible ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-warning text-white"
                                                onclick="editLocation({{ $item->loc_mstr_id }}, '{{ $item->loc_mstr_code }}', '{{ $item->loc_mstr_name }}', '{{ $item->loc_mstr_isvisible }}')">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <form action="{{ route('LocMstrList.destroy', $item->loc_mstr_id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="bi bi-trash"></i></button>
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

    <div class="modal fade" id="addLocModal" tabindex="-1" aria-labelledby="addLocModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('LocMstr.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLocModalLabel">
                            <i class="fas fa-warehouse me-2"></i>Tambah Gudang Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="loc_code" class="form-label fw-bold">Kode Gudang</label>
                            <input type="text" class="form-control @error('loc_mstr_code') is-invalid @enderror"
                                id="loc_code" name="loc_mstr_code" value="{{ old('loc_mstr_code') }}"
                                placeholder="Contoh: G01" required>
                        </div>

                        <div class="mb-3">
                            <label for="loc_name" class="form-label fw-bold">Nama Gudang</label>
                            <input type="text" class="form-control @error('loc_mstr_name') is-invalid @enderror"
                                id="loc_name" name="loc_mstr_name" value="{{ old('loc_mstr_name') }}"
                                placeholder="Contoh: Gudang Utama" required>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="loc_mstr_active" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" id="loc_active"
                                        name="loc_mstr_active"
                                        {{ old('loc_mstr_active', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="loc_active">Status Aktif</label>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="loc_mstr_isvisible" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" id="loc_isvisible"
                                        name="loc_mstr_isvisible"
                                        {{ old('loc_mstr_isvisible', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="loc_isvisible">Muncul di List</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Gudang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalLocation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="locationForm" method="POST" action="">
                    @csrf
                    <div id="methodField"></div>
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalTitle">Edit Lokasi</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kode Lokasi</label>
                            <input type="text" name="loc_mstr_code" id="loc_code"
                                class="form-control @error('loc_mstr_code') is-invalid @enderror"
                                value="{{ old('loc_mstr_code') }}" required>
                            @error('loc_mstr_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lokasi</label>
                            <input type="text" name="loc_mstr_name" id="loc_name"
                                class="form-control @error('loc_mstr_name') is-invalid @enderror"
                                value="{{ old('loc_mstr_name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tampilkan ke Kasir?</label>
                            <select name="loc_mstr_isvisible" id="loc_visible" class="form-select">
                                <option value="1" {{ old('loc_mstr_isvisible') == '1' ? 'selected' : '' }}>Ya
                                    (Visible)</option>
                                <option value="0" {{ old('loc_mstr_isvisible') == '0' ? 'selected' : '' }}>Tidak
                                    (Hidden)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" id="btnSubmit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const modal = new bootstrap.Modal(document.getElementById('modalLocation'));
            const form = document.getElementById('locationForm');

            function editLocation(id, code, name, visible) {
                document.getElementById('modalTitle').innerText = 'Edit Lokasi';
                document.getElementById('loc_code').value = code;
                document.getElementById('loc_name').value = name;
                document.getElementById('loc_visible').value = visible;

                // Enable input & set Route
                form.querySelectorAll('input, select').forEach(el => el.disabled = false);
                document.getElementById('btnSubmit').style.display = 'block';
                document.getElementById('methodField').innerHTML = '@method('PUT')';
                form.action = `/LocMstr/${id}`; // Sesuaikan dengan route update kamu

                modal.show();
            }
        </script>
        <script src="{{ 'assets/js/CustMstr/getData.js' }}"></script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
    @endpush
</x-app-layout>
