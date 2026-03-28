<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Stock Card</h3>
        </div>
        <div class="page-content">
            <div class="border-0 shadow-sm card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-grid-3x3-gap me-2"></i>Kartu Stok (Stock Card)
                    </h5>
                    <div class="ux-action-gap">
                        {{-- Slot untuk filter jika diperlukan --}}
                    </div>
                </div>

                <div class="card-body">
                    <div class="border-0 table-responsive">
                        <table id="productTable" class="table mb-0 align-middle table-ux table-hover">
                            <thead class="text-center table-dark">
                                <tr>
                                    <th style="width:5%">No</th>
                                    <th style="width:15%">Code</th>
                                    <th style="width:20%">Name</th>
                                    <th>Description</th>
                                    <th style="width:12%">Measurement</th>
                                    <th style="width:12%">Category</th>
                                    <th style="width:5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="px-3">
                                            <span class="fw-bold text-primary">{{ $product->code }}</span>
                                        </td>
                                        <td class="px-3">
                                            <span class="ux-main-text fw-bold">{{ $product->name }}</span>
                                        </td>
                                        <td class="px-3">
                                            <span class="ux-sub-text d-inline-block text-truncate"
                                                style="max-width: 250px;">
                                                {{ $product->description ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="px-3 border badge bg-light text-dark">
                                                {{ $product->measurement->name }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="ux-sub-text">
                                                {{ $product->cat->product_cat_name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="shadow-sm btn btn-view"
                                                onclick="window.location.href='{{ route('StockTransaction.DetStockCard', $product->id) }}'"
                                                title="Buka Kartu Stok">
                                                <i class="bi bi-folder2-open"></i>
                                            </button>
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
        <script src="{{ 'assets/js/ProductMstr/getData.js' }}"></script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
    @endpush
</x-app-layout>
