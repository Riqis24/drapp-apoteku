<x-app-layout>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Piutang Usaha</h3>
        </div>
        <div class="page-content">
            <div class="card ux-card">
                <div class="ux-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="bi bi-wallet2 me-2"></i>Account Receivable
                    </h5>

                    <button class="px-4 shadow-sm btn btn-primary fw-bold rounded-3" type="button"
                        onclick="window.open('{{ route('ArpayMstr.create') }}', '_blank')">
                        <i class="bi bi-cash-stack me-2"></i>Pay / Payment
                    </button>
                </div>

                <div class="card-body">
                    <div class="ux-filter-area">
                        <form action="{{ route('ArMstr.index') }}" method="GET" class="row g-3 align-items-end">
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
                                <a href="{{ route('ArMstr.index') }}"
                                    class="px-4 btn btn-light ms-2 rounded-3 text-muted">Reset</a>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="ExpenseTable" class="table table-ux">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">No</th>
                                    <th>Info Tagihan</th>
                                    <th>Customer</th>
                                    <th class="text-center">Jatuh Tempo</th>
                                    <th class="text-end">Rincian Nominal</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ars as $ar)
                                    <tr>
                                        <td class="text-center">
                                            <span class="ux-sub-text fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text text-primary">{{ $ar->ar_mstr_nbr }}</span>
                                            <span
                                                class="ux-sub-text">{{ \Carbon\Carbon::parse($ar->ar_mstr_date)->format('d/m/Y') }}</span>
                                        </td>
                                        <td>
                                            <span class="ux-main-text">{{ $ar->customer->name }}</span>
                                            <span class="ux-sub-text small">Log:
                                                {{ \Carbon\Carbon::parse($ar->created_at)->format('d/m/y H:i') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="px-2 border badge bg-light text-dark">
                                                {{ \Carbon\Carbon::parse($ar->ar_mstr_duedate)->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <span class="ux-amount d-block">{{ rupiah($ar->ar_mstr_amount) }}</span>
                                            <span class="ux-sub-text text-danger fw-bold">Sisa:
                                                {{ rupiah($ar->ar_mstr_balance) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="px-3 badge rounded-pill 
                                    bg-{{ $ar->ar_mstr_status == 'paid' ? 'success' : ($ar->ar_mstr_status == 'partial' ? 'warning' : 'danger') }}-subtle 
                                    text-{{ $ar->ar_mstr_status == 'paid' ? 'success' : ($ar->ar_mstr_status == 'partial' ? 'warning' : 'danger') }}">
                                                {{ strtoupper($ar->ar_mstr_status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('ArpayMstr.show', $ar->ar_mstr_id) }}"
                                                    class="btn-ux-action btn-view" title="History">
                                                    <i class="bi bi-clock-history"></i>
                                                </a>
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
        <script src="{{ 'assets/js/ExpenseTr/getData.js' }}"></script>
        <script src="{{ 'assets/js/alert.js' }}"></script>
    @endpush
</x-app-layout>
