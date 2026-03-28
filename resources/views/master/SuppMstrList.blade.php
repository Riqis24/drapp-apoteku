<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Supplier Master</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-truck me-2"></i>Master Supplier
                    </h5>

                    <button class="px-4 shadow-sm btn btn-primary fw-bold rounded-3" type="button"
                        onclick="window.open('{{ route('SupplierMstr.create') }}', '_blank')">
                        <i class="bi bi-plus-lg me-2"></i>Add Supplier
                    </button>
                </div>

                <div class="card-body">
                    <div class="border-0 table-responsive">
                        <table id="custTable" class="table align-middle table-ux nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th style="width:10%">Kode</th>
                                    <th>Nama Supplier</th>
                                    <th>Alamat</th>
                                    <th>No. Telp</th>
                                    <th class="text-center">PPN</th>
                                    <th class="text-center" style="width:10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $item)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <code class="text-primary fw-bold">{{ $item->supp_mstr_code }}</code>
                                        </td>
                                        <td>
                                            <span class="ux-main-text fw-bold">{{ $item->supp_mstr_name }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-sub-text text-truncate d-inline-block"
                                                style="max-width: 250px;" title="{{ $item->supp_mstr_addr }}">
                                                {{ $item->supp_mstr_addr ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="tel:{{ $item->supp_mstr_phone }}"
                                                class="text-decoration-none ux-main-text">
                                                <i
                                                    class="bi bi-telephone text-primary me-1"></i>{{ $item->supp_mstr_phone }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @if ($item->supp_mstr_ppn > 0)
                                                <span
                                                    class="px-3 badge rounded-pill bg-info-light text-info border-info">
                                                    {{ $item->supp_mstr_ppn }}%
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 border badge rounded-pill bg-light text-muted">Non-PPN</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="gap-2 d-flex justify-content-center">
                                                <a href="{{ route('SupplierMstr.edit', $item->supp_mstr_id) }}"
                                                    class="btn-ux-action btn-edit" title="Edit Supplier">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>

                                                <form action="{{ route('SuppMstrList.destroy', $item->supp_mstr_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-ux-action btn-delete"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')"
                                                        title="Hapus Supplier">
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

    @push('scripts')
        <script src="{{ 'assets/js/CustMstr/getData.js' }}"></script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
    @endpush
</x-app-layout>
