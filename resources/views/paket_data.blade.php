@extends('layout.admin.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Paket Data</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Paket Data</li>
        </ol>
        <form action="{{ route('paket_data.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="number" class="form-label">Nomor Telp</label>
                <input type="text" class="form-control" id="number" name="number" required>
            </div>
            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis Kartu</label>
                <input type="text" class="form-control" id="jenis" name="jenis" readonly>
            </div>
            <div class="mb-3">
                <label for="nominal" class="form-label">Pilih Paket</label>
                <select class="form-select" id="nominal" name="nominal" required>
                    <option value="">Pilih Paket Data</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<script>
    function detectJenisKartu() {
        var nomorTelp = document.getElementById("number").value;
        if (nomorTelp.startsWith("0812")) {
            return "Telkomsel";
        } else if (nomorTelp.startsWith("0857")) {
            return "Indosat";
        } else if (nomorTelp.startsWith("0831")) {
            return "Axis";
        } else if (nomorTelp.startsWith("0877")) {
            return "XL";
        } else if (nomorTelp.startsWith("0895")) {
            return "Three";
        } else {
            return "Unknown";
        }
    }

    // Fungsi untuk mengisi pilihan paket data berdasarkan jenis kartu
    function populatePaketData() {
    var jenisKartu = detectJenisKartu();
    var selectElement = document.getElementById("nominal");

    // Kosongkan pilihan paket data
    selectElement.innerHTML = '<option value="">Pilih Paket Data</option>';

    // Tambahkan pilihan paket data berdasarkan jenis kartu
    if (jenisKartu === "Telkomsel") {
        selectElement.innerHTML += `
            <option>10GB - Rp. 50.000 - {{ $paket->where('name', 'Paketdata Telkomsel 10GB')->first()->value }}</option>
            <option>1,5GB - Rp. 20.000 - {{ $paket->where('name', 'Paketdata Telkomsel 1.5GB')->first()->value }}</option>
            <option>14GB - Rp. 75.000 - {{ $paket->where('name', 'Paketdata Telkomsel 14GB')->first()->value }}</option>
        `;
    } else if (jenisKartu === "Indosat") {
        selectElement.innerHTML += `
            <option>90GB - Rp. 100.000 - {{ $paket->where('name', 'Paketdata Indosat 90GB')->first()->value }}</option>
            <option>30GB - Rp. 50.000 - {{ $paket->where('name', 'Paketdata Indosat 30GB')->first()->value }}</option>
            <option>10GB - Rp. 25.000 - {{ $paket->where('name', 'Paketdata Indosat 10GB')->first()->value }}</option>
        `;
    } else if (jenisKartu === "Axis") {
        selectElement.innerHTML += `
            <option>1,5GB - Rp. 15.000 - {{ $paket->where('name', 'Paketdata Axis 1.5GB')->first()->value }}</option>
            <option>3GB - Rp. 25.000 - {{ $paket->where('name', 'Paketdata Axis 3GB')->first()->value }}</option>
            <option>10GB - Rp. 50.000 - {{ $paket->where('name', 'Paketdata Axis 10GB')->first()->value }}</option>
        `;
    } else if (jenisKartu === "XL") {
        selectElement.innerHTML += `
            <option>66GB - Rp. 70.000 - {{ $paket->where('name', 'Paketdata XL 66GB')->first()->value }}</option>
            <option>186GB - Rp. 150.000 - {{ $paket->where('name', 'Paketdata XL 186GB')->first()->value }}</option>
            <option>122GB - Rp. 120.000 - {{ $paket->where('name', 'Paketdata XL 122GB')->first()->value }}</option>
        `;
    } else if (jenisKartu === "Three") {
        selectElement.innerHTML += `
            <option>9GB - Rp. 45.000 - {{ $paket->where('name', 'Paketdata Three 9GB')->first()->value }}</option>
            <option>42GB - Rp. 90.000 - {{ $paket->where('name', 'Paketdata Three 42GB')->first()->value }}</option>
            <option>30GB - Rp. 75.000 - {{ $paket->where('name', 'Paketdata Three 30GB')->first()->value }}</option>
        `;
    } 
}


    // Setel jenis kartu pelanggan saat input nomor telepon berubah
    document.getElementById("number").addEventListener("input", function() {
        var jenis = detectJenisKartu();
        document.getElementById("jenis").value = jenis;
        populatePaketData();
    });

    // Panggil populatePaketData saat halaman dimuat untuk pertama kali
    populatePaketData();
</script>

@endsection