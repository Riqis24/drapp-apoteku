<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Financial Record</h3>
            <p class="lead text-muted">Laporan arus kas pemasukan dan pengeluaran</p>
        </div>
        <div class="mb-4 border-0 shadow-sm card ux-card">
            <div class="pb-0 border-0 ux-header">
                <h5 class="mb-0 text-primary fw-bold">
                    <i class="bi bi-bar-chart-line me-2"></i>RINGKASAN KEUANGAN
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="overflow-hidden border-0 shadow-sm card rounded-4 position-relative"
                            style="background: linear-gradient(135deg, #ffffff 0%, #f0fff4 100%); border-left: 5px solid #198754 !important;">
                            <div class="p-4 card-body d-flex align-items-center">
                                <div class="p-3 shadow-sm me-3 rounded-4"
                                    style="background-color: rgba(25, 135, 84, 0.1);">
                                    <i class="bi bi-graph-up-arrow fs-2 text-success"></i>
                                </div>
                                <div>
                                    <small class="mb-1 ux-sub-text fw-bold d-block text-uppercase"
                                        style="letter-spacing: 1px; font-size: 0.7rem;">Total Pemasukan</small>
                                    <h3 class="mb-0 fw-bolder text-dark">
                                        <span class="fs-6 fw-normal text-muted">Rp</span>
                                        {{ number_format($totalIncome, 0, ',', '.') }}
                                    </h3>
                                </div>
                            </div>
                            <div class="position-absolute" style="right: -10px; bottom: -10px; opacity: 0.05;">
                                <i class="bi bi-cash-stack" style="font-size: 5rem;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="overflow-hidden border-0 shadow-sm card rounded-4 position-relative"
                            style="background: linear-gradient(135deg, #ffffff 0%, #fff5f5 100%); border-left: 5px solid #dc3545 !important;">
                            <div class="p-4 card-body d-flex align-items-center">
                                <div class="p-3 shadow-sm me-3 rounded-4"
                                    style="background-color: rgba(220, 53, 69, 0.1);">
                                    <i class="bi bi-graph-down-arrow fs-2 text-danger"></i>
                                </div>
                                <div>
                                    <small class="mb-1 ux-sub-text fw-bold d-block text-uppercase"
                                        style="letter-spacing: 1px; font-size: 0.7rem;">Total Pengeluaran</small>
                                    <h3 class="mb-0 fw-bolder text-dark">
                                        <span class="fs-6 fw-normal text-muted">Rp</span>
                                        {{ number_format($totalExpense, 0, ',', '.') }}
                                    </h3>
                                </div>
                            </div>
                            <div class="position-absolute" style="right: -10px; bottom: -10px; opacity: 0.05;">
                                <i class="bi bi-cart-x" style="font-size: 5rem;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="overflow-hidden text-white border-0 shadow card rounded-4 position-relative"
                            style="background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);">
                            <div class="p-4 card-body d-flex align-items-center">
                                <div class="p-3 shadow-sm me-3 rounded-4"
                                    style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(5px);">
                                    <i class="text-white bi bi-wallet2 fs-2"></i>
                                </div>
                                <div>
                                    <small class="mb-1 opacity-75 fw-bold d-block text-uppercase"
                                        style="letter-spacing: 1px; font-size: 0.7rem;">Saldo Akhir</small>
                                    <h3 class="mb-0 fw-bolder">
                                        <span class="opacity-75 fs-6 fw-normal">Rp</span>
                                        {{ number_format($saldo, 0, ',', '.') }}
                                    </h3>
                                </div>
                            </div>
                            <div class="position-absolute rounded-circle"
                                style="width: 100px; height: 100px; background: rgba(255,255,255,0.1); top: -20px; right: -20px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('FinancialRecord.index') }}" method="GET">
            <div class="mb-4 border-0 shadow-sm card ux-card">
                <div class="py-3 card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label ux-sub-text fw-bold">Tanggal Awal</label>
                            <input type="date" name="date1" class="form-control ux-input"
                                value="{{ request('date1') }}" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label ux-sub-text fw-bold">Tanggal Akhir</label>
                            <input type="date" name="date2" class="form-control ux-input"
                                value="{{ request('date2') }}" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label ux-sub-text fw-bold">Jenis Transaksi</label>
                            <select name="type" class="form-select ux-input">
                                <option value="" {{ request('type') == '' ? 'selected' : '' }}>Semua Jenis
                                </option>
                                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan
                                </option>
                                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="shadow-sm btn btn-primary w-100 fw-bold">
                                <i class="bi bi-filter me-2"></i>Terapkan Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-0 shadow-sm card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-list-ul me-2"></i>Daftar Riwayat Transaksi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="custTable" class="table align-middle table-ux table-hover" style="width:100%">
                            <thead class="text-center bg-light text-secondary">
                                <tr>
                                    <th style="width:5%">No</th>
                                    <th style="width:15%">Tanggal</th>
                                    <th style="width:12%">Tipe</th>
                                    <th>Keterangan / Deskripsi</th>
                                    <th style="width:18%">Nominal</th>
                                    <th style="width:15%">Sumber Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <span
                                                class="fw-bold text-dark">{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge border fw-normal {{ strtolower($record->type) == 'income' ? 'bg-success-light text-success border-success' : 'bg-danger-light text-danger border-danger' }}"
                                                style="padding: 0.5em 1em;">
                                                {{ strtoupper($record->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="ux-main-text fw-semibold">{{ $record->data_source }}</div>
                                            <small class="text-muted small">Ref ID: #{{ $record->source_id }}</small>
                                        </td>
                                        <td class="text-end">
                                            <span
                                                class="fw-bold {{ strtolower($record->type) == 'income' ? 'text-success' : 'text-danger' }}">
                                                {{ rupiah($record->amount) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="px-2 border badge bg-light text-secondary">
                                                @if ($record->source_type === \App\Models\SalesMstr::class && is_object($record->source))
                                                    Sales ({{ $record->source->sales_mstr_nbr ?? '-' }})
                                                @else
                                                    {{ class_basename($record->source_type) }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- modal add user --}}
    <form action="{{ route('Stock.store') }}" method="POST">
        @csrf
        <div class="modal fade" id="modalAddTransaction" tabindex="-1" aria-labelledby="modalAddTransactionLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddTransactionLabel">Cust Master</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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
