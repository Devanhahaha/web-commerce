@extends('layout.customer.maincust')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Riwayat Transaksi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Riwayat Transaksi Pemesanan Product</li>
            </ol>
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <button class="btn btn-primary" onclick="printReport()">Cetak Laporan</button>
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

            @foreach ($transaksi->groupBy(function ($item) {
            return $item->created_at->format('d F Y');
        }) as $tanggal => $transaksiHarian)
                <div class="card mb-4 report-card" data-type="all">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Riwayat Transaksi Tanggal {{ $tanggal }}
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Gambar</th>
                                    <th>Nama Product</th>
                                    <th>Jenis</th>
                                    <th>Merk</th>
                                    <th>Deskripsi</th>
                                    <th>Nominal</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Nama</th>
                                    <th>Kurir</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten</th>
                                    <th>Ongkir</th>
                                    <th>Alamat</th>
                                    <th>No Telp</th>
                                    <th>Informasi Tambahan</th>
                                    <th>Quantity</th>
                                    <th>Sub Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksiHarian->where('jenis_transaksi', 'PRODUCT')->all() as $item)
                                    <tr class="report-row" data-type="PRODUCT">
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img src="{{ asset($item->productcust->product->gambar) }}" alt="gambar"
                                                style="max-width: 100px"></td>
                                        <td>{{ $item->productcust->product->nama_product }}</td>
                                        <td>{{ $item->productcust->product->jenis }}</td>
                                        <td>{{ $item->productcust->product->merk }}</td>
                                        <td>{{ $item->productcust->product->deskripsi }}</td>
                                        <td style="text-align: right;">
                                            {{ number_format($item->productcust->product->nominal, 0, ',', '.') }}</td>
                                        <td>{{ $item->jenis_pembayaran }}</td>
                                        <td>{{ $item->user->first_name }}</td>
                                        <td>{{ $item->productcust->kurir }}</td>
                                        <td>{{ $item->productcust->provinsi }}</td>
                                        <td>{{ $item->productcust->kabupaten }}</td>
                                        <td>{{ $item->productcust->ongkir }}</td>
                                        <td>{{ $item->productcust->alamat }}</td>
                                        <td>{{ $item->productcust->no_hp }}</td>
                                        <td>{{ $item->productcust->catatan }}</td>
                                        <td>{{ $item->productcust->quantity }}</td>
                                        <td>{{ $item->productcust->sub_total }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            @if ($item->status === 'sudah di kirim')
                                                <form action="{{ route('orders.confirm', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary mt-2">Konfirmasi
                                                        Barang Telah Sampai</button>
                                                </form>
                                            @endif
                                            @if ($item->status === 'belum di kirim')
                                                <form action="{{ route('orders.cancel_request', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger mt-2">Batalkan
                                                        Pesanan</button>
                                                </form>
                                            @endif
                                        </td>
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
    <style>
        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table th {
            width: auto;
        }

        .table img {
            max-width: 100px;
            height: auto;
        }

        .card-body {
            overflow-x: auto;
        }
    </style>
@endsection
