<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Stock Transaction</h3>
        </div>
        <div class="page-content">
            <div class="border-0 shadow-sm card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-arrow-left-right me-2"></i>Log Transaksi Stok
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="custTable" class="table mb-0 align-middle table-ux nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th class="text-center" style="width:12%">Tanggal</th>
                                    <th style="width:20%">Product</th>
                                    <th class="text-center" style="width:15%">Batch</th>
                                    <th style="width:15%">Location</th>
                                    <th class="text-center" style="width:10%">Type</th>
                                    <th class="text-end" style="width:10%">Qty</th>
                                    <th style="width:13%">Source / Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trStocks as $trStock)
                                    <tr>
                                        <td class="text-center ux-sub-text">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <span class="d-block fw-bold text-dark" style="font-size: 0.85rem;">
                                                {{ $trStock->created_at->format('d/m/Y') }}
                                            </span>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                {{ $trStock->created_at->format('H:i') }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $trStock->product->name }}</div>
                                            <small class="text-muted">ID: #{{ $trStock->product_mstr_id }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="px-2 py-1 border badge bg-light text-dark">
                                                <i
                                                    class="bi bi-tag-fill me-1 text-secondary"></i>{{ $trStock->batch->batch_mstr_no }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                                <span>{{ $trStock->location->loc_mstr_name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if (strtolower($trStock->type) == 'in')
                                                <span class="px-3 badge bg-success-light text-success rounded-pill">
                                                    <i class="bi bi-box-arrow-in-down me-1"></i> IN
                                                </span>
                                            @else
                                                <span class="px-3 badge bg-danger-light text-danger rounded-pill">
                                                    <i class="bi bi-box-arrow-up me-1"></i> OUT
                                                </span>
                                            @endif
                                        </td>
                                        <td
                                            class="text-end fw-bold {{ strtolower($trStock->type) == 'in' ? 'text-success' : 'text-danger' }}">
                                            {{ strtolower($trStock->type) == 'in' ? '+' : '-' }}
                                            {{ number_format($trStock->quantity, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <small class="text-muted d-block"
                                                style="font-size: 0.7rem; text-transform: uppercase;">
                                                {{ str_replace('App\Models\\', '', $trStock->source_type) }}
                                            </small>
                                            <span class="ux-sub-text">{{ $trStock->note ?? '-' }}</span>
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
        <script src="{{ 'assets/js/StockTr/getData.js' }}"></script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
    @endpush
</x-app-layout>
