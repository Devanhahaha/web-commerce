@extends('layout.admin.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Laporan Transaksi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Laporan Transaksi Paket Data</li>
            </ol>
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <button class="btn btn-primary" onclick="printReport()">Cetak Laporan</button>
                </div>
                <div>
                    <!-- Dropdown Filter Bulan -->
                    <select id="monthFilter" class="form-select" onchange="filterReports()">
                        <option value="all">Semua Bulan</option>
                        @foreach ($transaksi->groupBy(function ($item) {
            return $item->created_at->format('F Y');
        }) as $bulan => $transaksiBulanan)
                            <option value="{{ $bulan }}">{{ $bulan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @php
                $totalPemasukanPerBulan = [];
            @endphp

            @foreach ($transaksi->groupBy(function ($item) {
            return $item->created_at->format('F Y');
        }) as $bulan => $transaksiBulanan)
                @php
                    $totalPemasukanBulanan = $transaksiBulanan
                        ->where('jenis_transaksi', 'PAKETDATA')
                        ->sum(function ($item) {
                            return (int) ($item->paketdata?->harga ?? 0);
                        });
                    $totalPemasukanPerBulan[$bulan] = $totalPemasukanBulanan;
                    $nomorUrut = 1;
                @endphp

                <div class="card mb-4 report-card" data-month="{{ $bulan }}" style="display: none;">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Laporan & Total Pendapatan Bulan {{ $bulan }}:
                        Rp{{ number_format($totalPemasukanBulanan, 0, ',', '.') }}
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Nomor Telp</th>
                                    <th>Jenis Kartu</th>
                                    <th>Nominal</th>
                                    <th>Harga</th>
                                    <th>Jenis Pembayaran</th>
                                    {{-- <th>Jenis Layanan</th> --}}
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksiBulanan->groupBy(function ($item) {
            return $item->created_at->format('d F Y');
        }) as $tanggal => $transaksiHarian)
                                    @foreach ($transaksiHarian->where('jenis_transaksi', 'PAKETDATA')->all() as $item)
                                        <tr class="report-row" data-month="{{ $bulan }}">
                                            <td>{{ $nomorUrut++ }}</td>
                                            <td>{{ $item->paketdata?->updated_at }}</td>
                                            <td>{{ $item->paketdata?->nama }}</td>
                                            <td>{{ $item->paketdata?->no_telp }}</td>
                                            <td>{{ $item->paketdata?->tipe_kartu }}</td>
                                            <td>{{ $item->paketdata?->nominal }}</td>
                                            <td>{{ $item->paketdata?->harga }}</td>
                                            <td>{{ $item->jenis_pembayaran }}</td>
                                            {{-- <td>{{ $item->jenis_transaksi }}</td> --}}
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
            var selectedMonth = document.getElementById('monthFilter').value;
            var cards = document.querySelectorAll('.report-card');

            // Tampilkan atau sembunyikan laporan berdasarkan bulan yang dipilih
            cards.forEach(function(card) {
                if (selectedMonth === 'all' || card.dataset.month === selectedMonth) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
@endsection
