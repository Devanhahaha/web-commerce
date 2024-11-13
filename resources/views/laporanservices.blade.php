@extends('layout.admin.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Laporan Transaksi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Laporan Transaksi Services</li>
            </ol>
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <button class="btn btn-primary" onclick="printReport()">Cetak Laporan</button>
                </div>
                <div>
                    <!-- Dropdown Filter Bulan -->
                    <select id="monthFilter" class="form-select" onchange="filterReports()">
                        <option value="all">Semua Bulan</option>
                        @foreach ($transaksi->groupBy(function ($item) { return $item->created_at->format('F Y'); }) as $bulan => $transaksiBulanan)
                            <option value="{{ $bulan }}">{{ $bulan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @php
                $totalPemasukanPerBulan = [];
            @endphp
            @foreach ($transaksi->groupBy(function ($item) { return $item->created_at->format('F Y'); }) as $bulan => $transaksiBulanan)
                @php
                    $totalPemasukanBulanan = $transaksiBulanan
                        ->where('jenis_transaksi', 'SERVICES')
                        ->sum(function ($item) { return $item->services?->nominal ?? 0; });
                    $totalPemasukanPerBulan[$bulan] = $totalPemasukanBulanan;
                    $nomorUrut = 1;
                @endphp
                <div class="card mb-4 report-card" data-month="{{ $bulan }}" style="display: none;">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        <strong>Laporan & Total Pendapatan Bulan {{ $bulan }}: Rp{{ number_format($totalPemasukanBulanan, 0, ',', '.') }}</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Kontak</th>
                                    <th>Jenis HP</th>
                                    <th>Keluhan</th>
                                    <th>Nominal</th>
                                    {{-- <th>Jenis Layanan</th> --}}
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksiBulanan->groupBy(function ($item) { return $item->created_at->format('d F Y'); }) as $tanggal => $transaksiHarian)
                                    @foreach ($transaksiHarian->where('jenis_transaksi', 'SERVICES')->all() as $item)
                                        <tr class="report-row" data-month="{{ $bulan }}" data-id="{{ $item->id }}">
                                            <td>{{ $nomorUrut++ }}</td>
                                            <td>{{ $item->services?->updated_at }}</td>
                                            <td>{{ $item->services?->nama }}</td>
                                            <td>{{ $item->services?->alamat }}</td>
                                            <td>{{ $item->services?->kontak }}</td>
                                            <td>{{ $item->services?->jenis_hp }}</td>
                                            <td>{{ $item->services?->keluhan }}</td>
                                            <td>
                                                <input type="number" class="form-control nominal-input" data-id="{{ $item->id }}" value="{{ $item->services?->nominal }}">
                                            </td>
                                            {{-- <td>{{ $item->jenis_transaksi }}</td> --}}
                                            <td class='status'>{{ $item->status }}</td>
                                            <td>
                                                <button class="btn btn-success save-nominal" data-id="{{ $item->id }}">Save</button>
                                            </td>
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
            window.print();
        }

        function filterReports() {
            var selectedMonth = document.getElementById('monthFilter').value;
            var cards = document.querySelectorAll('.report-card');

            cards.forEach(function(card) {
                if (selectedMonth === 'all' || card.dataset.month === selectedMonth) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.save-nominal').forEach(button => {
                button.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    var nominalInput = document.querySelector(`.nominal-input[data-id='${id}']`);
                    var nominal = nominalInput.value;

                    fetch('{{ route('update.nominal') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ id: id, nominal: nominal })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector(`.report-row[data-id='${id}'] .status`).innerText = 'Lunas';
                            alert('Nominal updated successfully');
                        } else {
                            alert('Failed to update nominal');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection
