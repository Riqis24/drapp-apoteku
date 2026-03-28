<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Stock</h3>
        </div>
        <div class="page-content">
            <div class="border-0 shadow-sm card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-box-seam me-2 text-primary"></i>Data Saldo Stok
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="custTable" class="table mb-0 align-middle table-ux table-hover" style="width:100%">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th>Product</th>
                                    <th class="text-center" style="width:18%">Batch & Expired</th>
                                    <th style="width:15%">Location</th>
                                    <th class="text-end" style="width:15%">Current Qty</th>
                                    <th class="text-center" style="width:10%">History</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $stock->product->name }}</div>
                                            <small class="text-muted" style="font-size: 0.75rem;">ID:
                                                {{ $stock->product_id }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-1 border badge bg-light text-dark fw-normal">
                                                {{ $stock->batch->batch_mstr_no }}
                                            </div>
                                            <div class="d-block" style="font-size: 0.75rem;">
                                                <span class="text-muted">Exp:</span>
                                                <span
                                                    class="{{ \Carbon\Carbon::parse($stock->batch->batch_mstr_expireddate)->isPast() ? 'text-danger fw-bold' : 'text-dark' }}">
                                                    {{ $stock->batch->batch_mstr_expireddate }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-geo-alt text-muted me-2"></i>
                                                <span>{{ $stock->loc->loc_mstr_name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span
                                                class="fs-6 fw-bold {{ $stock->quantity <= 0 ? 'text-danger' : 'text-dark' }}">
                                                {{ number_format($stock->quantity, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('stockHistory', $stock->id) }}"
                                                class="border-0 shadow-none btn btn-sm btn-outline-primary"
                                                title="Lihat Log Transaksi">
                                                <i class="bi bi-clock-history fs-5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="py-3 bg-white border-0 card-footer">
                </div>
            </div>
        </div>
    </div>

    {{-- modal add user --}}
    <form action="{{ route('Stock.store') }}" method="POST">
        @csrf
        <div class="modal fade" id="modalAddCustomer" tabindex="-1" aria-labelledby="modalAddCustomerLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddCustomerLabel">Cust Master</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height: 400px; overflow-y: scroll;">
                        <div id="dynamicCustsInputs">
                            <div class="cust-row">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control form-control-sm" name="names[]"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="address" class="form-label">Alamat</label>
                                        <input type="text" class="form-control form-control-sm" name="addresss[]"
                                            required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="phone" class="form-label">No HP</label>
                                        <input type="text" class="form-control form-control-sm" name="phones[]"
                                            required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="outstanding" class="form-label">Piutang</label>
                                        <input type="text" class="form-control form-control-sm" value="0"
                                            name="outstandings[]" required>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="" class="form-label">Remove</label>
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
        <script src="{{ 'assets/js/CustMstr/getData.js' }}"></script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
    @endpush
</x-app-layout>
