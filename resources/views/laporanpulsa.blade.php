@extends('layout.admin.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Laporan Transaksi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Laporan Transaksi Pulsa</li>
            </ol>
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <button class="btn btn-primary" onclick="printReport()">Cetak Laporan</button>
                </div>
                <div>
                    <!-- Filter Dropdown -->
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
            @if (session()->has('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @php
                $totalPemasukanPerBulan = [];
            @endphp
            @foreach ($transaksi->groupBy(function ($item) {
                return $item->created_at->format('F Y');
            }) as $bulan => $transaksiBulanan)
                @php
                    $totalPemasukanBulanan = $transaksiBulanan
                        ->where('jenis_transaksi', 'PULSA')
                        ->sum(function ($item) {
                            return $item->pulsa?->harga ?? 0;
                        });
                    $totalPemasukanPerBulan[$bulan] = $totalPemasukanBulanan;
                    $nomorUrut = 1; // Inisialisasi nomor urut di setiap bulan
                @endphp
                <div class="card mb-4 report-card" data-month="{{ $bulan }}" style="display: none;">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        <strong>Laporan & Total Pendapatan Bulan {{ $bulan }}:
                        Rp{{ number_format($totalPemasukanBulanan, 0, ',', '.') }}</strong>
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
                                    @foreach ($transaksiHarian->where('jenis_transaksi', 'PULSA')->all() as $item)
                                        <tr>
                                            <td>{{ $nomorUrut++ }}</td>
                                            <td>{{ $item->pulsa?->updated_at }}</td>
                                            <td>{{ $item->pulsa?->nama }}</td>
                                            <td>{{ $item->pulsa?->no_telp }}</td>
                                            <td>{{ $item->pulsa?->tipe_kartu }}</td>
                                            <td>{{ $item->pulsa?->nominal }}</td>
                                            <td>{{ $item->pulsa?->harga }}</td>
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
            var filter = document.getElementById('monthFilter').value;
            var cards = document.querySelectorAll('.report-card');

            cards.forEach(function(card) {
                if (filter === 'all' || card.dataset.month === filter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
@endsection
