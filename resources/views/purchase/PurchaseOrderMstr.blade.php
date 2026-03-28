<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Purchase Order</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-cart-check me-2"></i>Purchase Order
                    </h5>

                    <button class="px-4 shadow-sm btn btn-primary fw-bold rounded-3" type="button"
                        onclick="window.location.href='{{ route('PurchaseOrder.create') }}'">
                        <i class="bi bi-plus-lg me-2"></i>Create PO
                    </button>
                </div>

                <div class="card-body">
                    <div class="ux-filter-area">
                        <form action="{{ route('PurchaseOrder.index') }}" method="GET"
                            class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label ux-sub-text fw-bold">DARI TANGGAL</label>
                                <input type="date" name="start_date" class="border-0 shadow-sm form-control"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label ux-sub-text fw-bold">SAMPAI TANGGAL</label>
                                <input type="date" name="end_date" class="border-0 shadow-sm form-control"
                                    value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="px-4 shadow-sm btn btn-primary fw-bold rounded-3">
                                    <i class="bi bi-filter"></i> Apply
                                </button>
                                <a href="{{ route('PurchaseOrder.index') }}"
                                    class="px-4 btn btn-light ms-2 rounded-3 text-muted">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="PoTable" class="table table-ux">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th>Info PO</th>
                                    <th>Supplier</th>
                                    <th class="text-center">Estimasi (ETA)</th>
                                    <th class="text-end">Rincian Biaya</th>
                                    <th>Payment & Tempo</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $item)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text text-primary">{{ $item->po_mstr_nbr }}</span>
                                            <span class="ux-sub-text">Tgl:
                                                {{ \Carbon\Carbon::parse($item->po_mstr_createdat)->format('d/m/Y') }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text">{{ $item->supplier->supp_mstr_name }}</span>
                                            <span class="ux-sub-text small">By: {{ $item->user->user_mstr_name }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="px-2 border badge bg-light text-dark fw-normal">
                                                {{ $item->po_mstr_eta ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="ux-sub-text small text-muted" style="line-height: 1.2">
                                                Sub: {{ rupiah($item->po_mstr_subtotal) }}<br>
                                                Disc: <span
                                                    class="text-danger">-{{ rupiah($item->po_mstr_discamt) }}</span><br>
                                                Tax: <span
                                                    class="text-success">+{{ rupiah($item->po_mstr_ppnamt) }}</span>
                                            </div>
                                            <span
                                                class="mt-1 ux-amount d-block">{{ rupiah($item->po_mstr_grandtotal) }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="ux-main-text small text-uppercase">{{ $item->po_mstr_payment }}</span>
                                            <span class="ux-sub-text small">Due:
                                                {{ $item->po_mstr_duedate ?? '-' }}</span>
                                            @if ($item->po_mstr_note)
                                                <span class="ux-sub-text x-small text-italic text-truncate d-block"
                                                    style="max-width: 150px;">
                                                    "{{ $item->po_mstr_note }}"
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="gap-2 d-flex justify-content-center">
                                                <a href="#"
                                                    onclick="window.open('{{ route('PurchaseOrder.show', $item->po_mstr_id) }}')"
                                                    class="btn-ux-action btn-view" title="Detail PO">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <form id="delete-po-{{ $item->po_mstr_id }}"
                                                    action="{{ route('PurchaseOrderList.destroy', $item->po_mstr_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-ux-action btn-delete"
                                                        onclick="confirmDeletePo('{{ $item->po_mstr_id }}', '{{ $item->po_mstr_nbr }}')"
                                                        title="Hapus">
                                                        <i class="bi bi-trash"></i>
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
        <script>
            $("#PoTable").DataTable({
                scrollX: true, // Wajib untuk tabel lebar seperti ini
                scrollY: "350px",
                scrollCollapse: true,
                autoWidth: false, // MATIKAN agar kita bisa kontrol via CSS
                paging: true,

            });
        </script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
        <script>
            function confirmDeletePo(id, poNumber) {
                Swal.fire({
                    title: 'Hapus Purchase Order?',
                    text: `Apakah Anda yakin ingin menghapus PO: ${poNumber}? Data tidak dapat dikembalikan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form secara manual
                        document.getElementById('delete-po-' + id).submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
