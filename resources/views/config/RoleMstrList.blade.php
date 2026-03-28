<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Role Master</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-shield-check me-2"></i>Master Role & Akses
                    </h5>

                    <button class="px-4 shadow-sm btn btn-primary fw-bold rounded-3" type="button"
                        data-bs-toggle="modal" data-bs-target="#modalAddRole">
                        <i class="bi bi-plus-lg me-2"></i>Add Role
                    </button>
                </div>

                <div class="card-body">
                    <div class="border-0 table-responsive">
                        <table id="roleTable" class="table align-middle table-ux nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th>Nama Role</th>
                                    <th class="text-center" style="width:20%">Guard Name</th>
                                    <th class="text-center" style="width:10%">Set Permission</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text fw-bold text-uppercase">{{ $role->name }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="px-3 border badge bg-light text-secondary">
                                                {{ $role->guard_name }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <button type="button" class="btn-ux-action btn-edit"
                                                    onclick="window.location.href='{{ route('RoleMstr.assignRole', $role->id) }}'"
                                                    title="Assign Permissions">
                                                    <i class="bi bi-shield-lock-fill"></i>
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
    <form action="{{ route('RoleMstr.store') }}" method="POST">
        @csrf
        <div class="modal fade" id="modalAddRole" tabindex="-1" aria-labelledby="modalAddRoleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddRoleLabel">Role Master</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="dynamicRoleInputs">
                            <div class="role-row">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" class="form-control form-control-sm" name="roles[]"
                                            placeholder="Contoh: Admin" required>
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

    @push('scripts')
        <script src="{{ 'assets/js/RoleMstr/getData.js' }}"></script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
    @endpush
</x-app-layout>
