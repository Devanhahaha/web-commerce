@extends('layout.admin.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Laporan Transaksi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Laporan Transaksi Pemesanan Product</li>
            </ol>
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <button class="btn btn-primary" onclick="printReport()">Cetak Laporan</button>
                </div>
                <div>
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
                        ->where('jenis_transaksi', 'PRODUCT')
                        ->sum(function ($item) {
                            return $item->productcust->sub_total ?? 0;
                        });
                    $nomorUrut = 1;
                @endphp
                <div class="card mb-4 report-card" data-month="{{ $bulan }}">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        <strong>Laporan & Total Pendapatan Bulan {{ $bulan }}:
                            <span class="total-pemasukan-bulanan">
                                Rp{{ number_format($totalPemasukanBulanan, 0, ',', '.') }}
                            </span>
                        </strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatablesSimple" class="table table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No.</th>
                                        <th style="width: 50px;">Tanggal</th>
                                        <th style="width: 100px;">Gambar</th>
                                        <th style="width: 150px;">Nama Product</th>
                                        <th style="width: 100px;">Jenis</th>
                                        <th style="width: 100px;">Merk</th>
                                        <th style="width: 200px;">Deskripsi</th>
                                        <th style="width: 100px;">Harga</th>
                                        <th style="width: 150px;">Jenis Pembayaran</th>
                                        <th style="width: 100px;">Nama</th>
                                        <th style="width: 150px;">Alamat</th>
                                        <th style="width: 120px;">No Telp</th>
                                        <th style="width: 200px;">Informasi Tambahan</th>
                                        <th style="width: 200px;">Provinsi</th>
                                        <th style="width: 200px;">Kabupaten</th>
                                        <th style="width: 200px;">Ongkir</th>
                                        <th style="width: 200px;">Kurir</th>
                                        <th style="width: 200px;">Quantity</th>
                                        <th style="width: 200px;">Subtotal</th>
                                        <th style="width: 150px;">Status</th>
                                        <th style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksiBulanan->groupBy(function ($item) {
            return $item->created_at->format('d F Y');
        }) as $tanggal => $transaksiHarian)
                                        @foreach ($transaksiHarian->where('jenis_transaksi', 'PRODUCT')->all() as $item)
                                            <tr class="report-row" data-month="{{ $bulan }}">
                                                <td>{{ $nomorUrut++ }}</td>
                                                <td>{{ $item->productcust->updated_at }}</td>
                                                <td>
                                                    @if ($item->productcust && $item->productcust->product)
                                                        <img src="{{ asset($item->productcust->product->gambar) }}"
                                                            alt="gambar" style="max-width: 100px">
                                                    @else
                                                        No Image Available
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->productcust && $item->productcust->product)
                                                        {{ $item->productcust->product->nama_product }}
                                                    @else
                                                        No Product Name Available
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->productcust && $item->productcust->product)
                                                        {{ $item->productcust->product->jenis }}
                                                    @else
                                                        No Product Type Available
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->productcust && $item->productcust->product)
                                                        {{ $item->productcust->product->merk }}
                                                    @else
                                                        No Product Merk Available
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->productcust && $item->productcust->product)
                                                        {{ $item->productcust->product->deskripsi }}
                                                    @else
                                                        No Product Description Available
                                                    @endif
                                                </td>
                                                <td style="text-align: right;">
                                                    @if ($item->productcust && $item->productcust->product)
                                                        {{ number_format($item->productcust->product->nominal, 0, ',', '.') }}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td>{{ $item->jenis_pembayaran }}</td>
                                                <td>{{ $item->user->first_name }}</td>
                                                <td>{{ $item->productcust->alamat ?? 'No Address Available' }}</td>
                                                <td>{{ $item->productcust->no_hp ?? 'No Phone Available' }}</td>
                                                <td>{{ $item->productcust->catatan ?? 'No Additional Info Available' }}
                                                </td>
                                                <td>{{ $item->productcust->provinsi ?? 'No Province Available' }}</td>
                                                <td>{{ $item->productcust->kabupaten ?? 'No City Available' }}</td>
                                                <td>{{ $item->productcust->ongkir ?? 'No Shipping Cost Available' }}</td>
                                                <td>{{ $item->productcust->kurir ?? 'No Courier Info Available' }}</td>
                                                <td>{{ $item->productcust->quantity ?? 0 }}</td>
                                                <td>{{ $item->productcust->sub_total ?? 0 }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>
                                                    @if ($item->status == 'belum di kirim')
                                                        <form action="{{ route('orders.ship', $item->id) }}" method="POST"
                                                            style="display:inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-primary mt-2">Ubah
                                                                Status ke "Sudah di Kirim"</button>
                                                        </form>
                                                    @elseif ($item->status == 'pembatalan diajukan')
                                                        <form action="{{ route('orders.cancel', $item->id) }}"
                                                            method="POST" style="display:inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-primary mt-2">Konfirmasi
                                                                Pembatalan</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <script>
        function printReport() {
            window.print();
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

        function filterReports() {
            var selectedMonth = document.getElementById('monthFilter').value;
            var cards = document.querySelectorAll('.report-card');
            var rows = document.querySelectorAll('.report-row');

            var totalMonthlyIncome = 0;

            cards.forEach(function(card) {
                var month = card.dataset.month;
                if (selectedMonth === 'all' || month === selectedMonth) {
                    card.style.display = '';
                    if (month === selectedMonth) {
                        totalMonthlyIncome += parseInt(card.querySelector('.total-pemasukan-bulanan').innerText
                            .replace(/[^0-9]/g, ''));
                    }
                } else {
                    card.style.display = 'none';
                }
            });

            rows.forEach(function(row) {
                var month = row.dataset.month;
                row.style.display = (selectedMonth === 'all' || month === selectedMonth) ? '' : 'none';
            });

            // Display the total income for the selected month
            if (selectedMonth !== 'all') {
                document.getElementById('totalMonthlyIncome').innerText =
                    `Total Pendapatan Bulan ${selectedMonth}: Rp${totalMonthlyIncome.toLocaleString('id-ID')}`;
            } else {
                document.getElementById('totalMonthlyIncome').innerText = '';
            }
        }
    </script>
@endsection
