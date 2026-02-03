<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Tutup Kasir - {{ $data['kasir'] }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 9pt;
            line-height: 1.2;
            width: 48mm;
            color: #000;
            margin: 0;
            padding: 5px;
            box-sizing: border-box;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        td {
            vertical-align: top;
            word-wrap: break-word;
        }

        .item-table td:first-child {
            width: 50%;
        }

        .item-table td:last-child {
            width: 50%;
        }

        .grand-total {
            font-size: 10pt;
            border-top: 1px solid #000;
            margin-top: 2px;
        }

        .footer {
            margin-top: 10px;
            font-size: 8pt;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <span class="fw-bold" style="font-size: 11pt;">{{ $apotek->name ?? 'Apotek' }}</span><br>
        Kasir: {{ $data['kasir'] ?? '-' }}<br>
        {{ $data['tanggal'] }}
    </div>

    <div class="divider"></div>

    {{-- BAGIAN 1: RINGKASAN PENJUALAN --}}
    <table class="item-table">
        <tr>
            <td>Bruto</td>
            <td class="text-right">{{ rupiah($data['bruto']) }}</td>
        </tr>
        <tr>
            <td>Disc</td>
            <td class="text-right">({{ rupiah($data['diskon']) }})</td>
        </tr>
        <tr>
            <td>PPN</td>
            <td class="text-right">{{ rupiah($data['ppn']) }}</td>
        </tr>
        <tr class="fw-bold grand-total">
            <td>OMZET (Net)</td>
            <td class="text-right">{{ rupiah($data['omzet']) }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- BAGIAN 2: RINCIAN METODE BAYAR (SISTEM) --}}
    <table class="item-table">
        <tr>
            <td>Modal Awal</td>
            <td class="text-right">{{ rupiah($activeSession->opening_amount) }}</td>
        </tr>
        <tr>
            <td>Tunai</td>
            <td class="text-right">{{ rupiah($data['cash']) }}</td>
        </tr>
        <tr>
            <td>QRIS</td>
            <td class="text-right">{{ rupiah($data['qris']) }}</td>
        </tr>
        <tr>
            <td>Transfer</td>
            <td class="text-right">{{ rupiah($data['transfer']) }}</td>
        </tr>
        <tr>
            <td>Kartu C/D</td>
            <td class="text-right">{{ rupiah($data['creditcard']) }}</td>
        </tr>
        <tr class="fw-bold">
            <td>TOTAL SISTEM</td>
            <td class="text-right">{{ rupiah($activeSession->opening_amount + $data['ttlTransactions']) }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- BAGIAN 3: PERBANDINGAN FISIK & SELISIH --}}
    <table class="item-table">
        <tr class="fw-bold">
            <td>TOTAL FISIK</td>
            <td class="text-right">{{ rupiah($activeSession->closing_amount) }}</td>
        </tr>
        <tr>
            <td>SELISIH</td>
            <td class="text-right">
                @php $selisih = $activeSession->closing_amount - ($activeSession->opening_amount + $data['ttlTransactions']); @endphp
                {{ $selisih > 0 ? '+' : '' }}{{ rupiah($selisih) }}
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="text-center footer">
        Waktu Cetak: {{ now()->format('d/m/Y H:i:s') }}<br>
        -- LAPORAN TUTUP KASIR --
        <br><br>
        (....................)<br>
        Tanda Tangan Kasir
    </div>

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        }
    </script>
</body>

</html>
