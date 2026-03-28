<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>User Master</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-person-badge-fill me-2"></i>Manajemen User
                    </h5>

                    <button class="px-4 shadow-sm btn btn-primary fw-bold rounded-3" type="button"
                        data-bs-toggle="modal" data-bs-target="#modalAddUser">
                        <i class="bi bi-person-plus-fill me-2"></i>Add User
                    </button>
                </div>

                <div class="card-body">
                    <div class="border-0 table-responsive">
                        <table id="userTable" class="table align-middle table-ux nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email Aktif</th>
                                    <th style="width:15%">Password</th>
                                    <th class="text-center" style="width:15%">Role / Akses</th>
                                    <th class="text-center" style="width:10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr data-id="{{ $user->user_mstr_id }}">
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>

                                        <td>
                                            <div class="name-display ux-main-text fw-bold">{{ $user->user_mstr_name }}
                                            </div>
                                            <input type="text" name="f_Name"
                                                class="shadow-sm form-control form-control-sm name-input d-none"
                                                value="{{ $user->user_mstr_name }}">
                                        </td>

                                        <td>
                                            <div class="email-display ux-sub-text">
                                                <i
                                                    class="bi bi-envelope me-1 text-secondary"></i>{{ $user->user_mstr_email }}
                                            </div>
                                            <input type="email" name="f_Email"
                                                class="shadow-sm form-control form-control-sm email-input d-none"
                                                value="{{ $user->user_mstr_email }}">
                                        </td>

                                        <td>
                                            <div class="password-display text-muted small">
                                                <i class="bi bi-shield-lock me-1"></i>••••••••
                                            </div>
                                            <input type="text" name="f_Password"
                                                class="shadow-sm form-control form-control-sm password-input d-none"
                                                placeholder="Isi untuk ubah...">
                                        </td>

                                        <td class="text-center">
                                            <div class="role-display">
                                                <span
                                                    class="px-3 badge rounded-pill bg-info-light text-info border-info">
                                                    {{ ucfirst($user->user_mstr_role) }}
                                                </span>
                                            </div>
                                            <select name="role"
                                                class="shadow-sm form-select form-select-sm role-input d-none">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}"
                                                        {{ $role->name == $user->user_mstr_role ? 'selected' : '' }}>
                                                        {{ ucfirst($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="text-center">
                                            <div class="gap-2 d-flex justify-content-center">
                                                <button class="btn-ux-action btn-edit edit-btn" title="Edit User">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>

                                                <button
                                                    data-url="{{ route('UserMstr.updateInline', $user->user_mstr_id) }}"
                                                    class="btn-ux-action btn-save update-btn d-none"
                                                    title="Simpan Perubahan">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>

                                                <button class="btn-ux-action btn-delete cancel-btn d-none"
                                                    onclick="location.reload()" title="Batal">
                                                    <i class="bi bi-x-lg"></i>
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

    {{-- modal add user --}}
    <form action="{{ route('UserMstr.store') }}" method="POST">
        @csrf
        <div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="modalAddUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddUserLabel">Add User Master</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="fid_Name">Name</label>
                                <input type="text" class="form-control form-control-sm" id="fid_Name"
                                    name="f_Name">
                            </div>
                            <div class="mt-2 col-md-12">
                                <label for="fid_Email">Email</label>
                                <input type="text" class="form-control form-control-sm" id="fid_Email"
                                    name="f_Email">
                            </div>
                            <div class="mt-2 col-md-12">
                                <label for="fid_Password">Password</label>
                                <input type="text" class="form-control form-control-sm" id="fid_Password"
                                    name="f_Password">
                            </div>
                            <div class="mt-2 col-md-12">
                                <label for="fid_Password">Role</label>
                                <select class="form-select form-select-sm" style="width: 100%" name="f_Role"
                                    id="fid_Role">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
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

    @push('scripts')
        <script src="{{ asset('assets/js/UserMstr/getData.js') }}"></script>
        <script src="{{ asset('assets/js/alert.js') }}"></script>
    @endpush
</x-app-layout>
