<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>History</h3>
        </div>
        <div class="page-content">
            <div class="border-0 shadow-sm card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-clock-history me-2"></i>History Transaksi Produk
                    </h5>
                    <button type="button" class="px-3 btn btn-outline-secondary btn-sm rounded-pill"
                        onclick="window.location.href='{{ route('Stock.index') }}'">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="historyTable" class="table mb-0 align-middle table-ux nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th>Product</th>
                                    <th class="text-center">Kategori</th>
                                    <th>Location</th>
                                    <th class="text-center">Batch / Exp</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-end">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Sub Total</th>
                                    <th>Cust/Vend</th>
                                    <th class="text-center">Reference</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $index => $st)
                                    @php
                                        $lookupKey = $st->id;
                                        $itemInfo = $detailsMap[$lookupKey] ?? null;
                                        $unitPrice = $itemInfo['price'] ?? 0;

                                        $subtotal = $itemInfo
                                            ? $itemInfo['total'] ?? $itemInfo['price'] * $st->quantity
                                            : 0;
                                        $isHpp = !$itemInfo;

                                        $formNote =
                                            match ($st->source_type) {
                                                \App\Models\SalesMstr::class => $st->source?->sales_mstr_note,
                                                \App\Models\BpbMstr::class => $st->source?->bpb_mstr_note,
                                                \App\Models\SrMstr::class => $st->source?->sr_mstr_reason,
                                                \App\Models\PrMstr::class => $st->source?->pr_mstr_reason,
                                                \App\Models\SaMstr::class => $st->source?->sa_mstr_reason,
                                                \App\Models\TsMstr::class => $st->source?->ts_mstr_note,
                                                default => $st->note,
                                            } ?? '-';

                                        $referenceNbr =
                                            match ($st->source_type) {
                                                \App\Models\SalesMstr::class => $st->source?->sales_mstr_nbr,
                                                \App\Models\BpbMstr::class => $st->source?->bpb_mstr_nbr,
                                                \App\Models\SaMstr::class => $st->source?->sa_mstr_nbr,
                                                \App\Models\PrMstr::class => $st->source?->pr_mstr_nbr,
                                                \App\Models\SrMstr::class => $st->source?->sr_mstr_nbr,
                                                \App\Models\TsMstr::class => $st->source?->ts_mstr_nbr,
                                                default => '-',
                                            } ?? '-';

                                        $route =
                                            match ($st->source_type) {
                                                \App\Models\SalesMstr::class => 'SalesMstr.show',
                                                \App\Models\BpbMstr::class => 'BpbMstr.show',
                                                \App\Models\SaMstr::class => 'SaMstr.show',
                                                \App\Models\PrMstr::class => 'PrMstr.show',
                                                \App\Models\SrMstr::class => 'SrMstr.show',
                                                \App\Models\TsMstr::class => 'TsMstr.show',
                                                default => '-',
                                            } ?? '-';
                                    @endphp
                                    <tr>
                                        <td class="text-center ux-sub-text">{{ $transactions->firstItem() + $index }}
                                        </td>
                                        <td class="text-center" style="font-size: 0.85rem;">
                                            {{ \Carbon\Carbon::parse($st->created_at)->format('d/m/Y') }}<br>
                                            <small
                                                class="text-muted">{{ \Carbon\Carbon::parse($st->created_at)->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <span class="ux-main-text fw-bold">{{ $st->product->name }}</span>
                                            @if ($isHpp)
                                                <span class="p-0 border-0 badge bg-light text-dark"
                                                    style="font-size: 10px;">(HPP)</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="border badge bg-light text-secondary">
                                                {{ str_replace('App\Models\\', '', str_replace('Mstr', '', $st->source_type)) }}
                                            </span>
                                        </td>
                                        <td><i
                                                class="bi bi-geo-alt text-muted me-1"></i>{{ $st->location->loc_mstr_name ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            <div class="ux-sub-text fw-bold text-dark">
                                                {{ $st->batch->batch_mstr_no ?? '-' }}</div>
                                            <small class="text-danger"
                                                style="font-size: 10px;">{{ $st->batch->batch_mstr_expireddate ?? '-' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge {{ $st->type == 'in' ? 'bg-success' : 'bg-danger' }} rounded-pill"
                                                style="min-width: 45px;">
                                                {{ strtoupper($st->type) }}
                                            </span>
                                        </td>
                                        <td
                                            class="text-end fw-bold {{ $st->type == 'in' ? 'text-success' : 'text-danger' }}">
                                            {{ $st->type == 'in' ? '+' : '-' }}{{ (float) $st->quantity }}
                                        </td>
                                        <td class="text-end text-muted">{{ number_format($unitPrice, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end fw-bold">{{ number_format($subtotal, 0, ',', '.') }}</td>
                                        <td class="ux-sub-text">
                                            @php
                                                $entity = match ($st->source_type) {
                                                    \App\Models\SalesMstr::class, \App\Models\SrMstr::class => $st
                                                        ->source->customer->name ?? 'Umum',
                                                    \App\Models\BpbMstr::class, \App\Models\PrMstr::class => $st->source
                                                        ->supplier->supp_mstr_name ?? '-',
                                                    default => '-',
                                                };
                                            @endphp
                                            {{ $entity }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ $route !== '-' ? route($route, $st->source_id) : '#' }}"
                                                class="text-primary text-decoration-none fw-bold small">
                                                {{ $referenceNbr }}
                                            </a>
                                        </td>
                                        <td class="small text-muted"
                                            style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $formNote }}
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
            $("#historyTable").DataTable({
                scrollX: true, // Wajib untuk tabel lebar seperti ini
                scrollY: "350px",
                scrollCollapse: true,
                autoWidth: false, // MATIKAN agar kita bisa kontrol via CSS
                paging: true,

            });
        </script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
    @endpush
</x-app-layout>
