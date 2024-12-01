@extends('layout.admin.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Laporan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Laporan</li>
        </ol>
        <div class="d-flex justify-content-between mb-4">
            <div>
                <button class="btn btn-primary" onclick="printReport()">Cetak Laporan</button>
            </div>
        </div>
        @foreach($transaksi->groupBy(function($item) { return $item->created_at->format('d F Y'); }) as $tanggal => $transaksiHarian)
            <div class="card mb-4 report-card" data-type="all">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Laporan Tanggal {{ $tanggal }}
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nomor Telp/Nomor Tagihan</th>
                                <th>Nominal</th>
                                <th>Jenis Layanan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksiHarian->where('jenis_transaksi', 'PULSA')->all() as $item)
                                <tr class="report-row" data-type="PULSA">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->pulsa?->nama }}</td>
                                    <td>{{ $item->pulsa?->no_telp }}</td>
                                    <td>{{ $item->pulsa?->nominal }}</td>
                                    <td>{{ $item->jenis_transaksi }}</td>
                                    <td>{{ $item->status }}</td>
                                </tr>
                            @endforeach
                            @foreach ($transaksiHarian->where('jenis_transaksi', 'PAKETDATA')->all() as $item)
                                <tr class="report-row" data-type="PAKETDATA">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->paketdata?->nama }}</td>
                                    <td>{{ $item->paketdata?->no_telp }}</td>
                                    <td>{{ $item->paketdata?->nominal }}</td>
                                    <td>{{ $item->jenis_transaksi }}</td>
                                    <td>{{ $item->status }}</td>
                                </tr>
                            @endforeach
                            @foreach ($transaksiHarian->where('jenis_transaksi', 'BAYARTAGIHAN')->all() as $item)
                                <tr class="report-row" data-type="BAYARTAGIHAN">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->bayartagihan?->nama }}</td>
                                    <td>{{ $item->bayartagihan?->no_tagihan }}</td>
                                    <td>{{ $item->bayartagihan?->nominal }}</td>
                                    <td>{{ $item->jenis_transaksi }}</td>
                                    <td>{{ $item->status }}</td>
                                </tr>
                            @endforeach
                            @foreach ($transaksiHarian->where('jenis_transaksi', 'SERVICES')->all() as $item)
                                <tr class="report-row" data-type="SERVICES">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->services?->nama }}</td>
                                    {{-- <td>{{ $item->services?->jenis_hp }}</td> --}}
                                    <td>{{ $item->services?->kontak }}</td>
                                    <td>{{ $item->services?->nominal }}</td>
                                    <td>{{ $item->jenis_transaksi }}</td>
                                    <td>{{ $item->status }}</td>
                                </tr>
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