@extends('layout.admin.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Laporan Transaksi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Laporan Transaksi Bayar Tagihan</li>
        </ol>
        <div class="d-flex justify-content-between mb-4">
            <div>
                <button class="btn btn-primary" onclick="printReport()">Cetak Laporan</button>
            </div>
        </div>

        @php
            $totalPemasukanPerBulan = [];
        @endphp

        @foreach($transaksi->groupBy(function($item) { return $item->created_at->format('F Y'); }) as $bulan => $transaksiBulanan)
            @php
                $totalPemasukanBulanan = $transaksiBulanan->where('jenis_transaksi', 'BAYARTAGIHAN')->sum(function($item) {
                    return (int) ($item->bayartagihan?->nominal ?? 0);
                });
                $totalPemasukanPerBulan[$bulan] = $totalPemasukanBulanan;
                $nomorUrut = 1;
            @endphp

            <div class="card mb-4 report-card" data-type="all">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Laporan & Total Pendapatan Bulan {{ $bulan }}: Rp{{ number_format($totalPemasukanBulanan, 0, ',', '.') }}
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Nomor Tagihan</th>
                                <th>Nominal</th>
                                <th>Jenis Pembayaran</th>
                                <th>Jenis Layanan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksiBulanan->groupBy(function($item) { return $item->created_at->format('d F Y'); }) as $tanggal => $transaksiHarian)
                                @foreach ($transaksiHarian->where('jenis_transaksi', 'BAYARTAGIHAN')->all() as $item)
                                    <tr class="report-row" data-type="BAYARTAGIHAN">
                                        <td>{{ $nomorUrut++ }}</td>
                                        <td>{{ $item->bayartagihan?->updated_at }}</td>
                                        <td>{{ $item->bayartagihan?->nama }}</td>
                                        <td>{{ $item->bayartagihan?->no_tagihan }}</td>
                                        <td>{{ $item->bayartagihan?->nominal }}</td>
                                        <td>{{ $item->jenis_pembayaran }}</td>
                                        <td>{{ $item->jenis_transaksi }}</td>
                                        <td>{{ $item->status }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</main>

<script>
    function printReport() {
        window.print(); // Fungsi untuk mencetak laporan
    }

    function filterReports() {
        var filter = document.getElementById('reportFilter').value;
        var cards = document.querySelectorAll('.report-card');
        var rows = document.querySelectorAll('.report-row');

        cards.forEach(function(card) {
            if (filter === 'all' || card.dataset.type === filter) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });

        rows.forEach(function(row) {
            if (filter === 'all' || row.dataset.type === filter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection
