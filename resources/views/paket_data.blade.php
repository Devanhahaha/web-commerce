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
    // Fungsi untuk mendeteksi jenis kartu berdasarkan nomor telepon
    function detectJenisKartu() {
        var nomorTelp = document.getElementById("number").value;
        if (nomorTelp.startsWith("0813")) {
            return "Telkomsel";
        } else if (nomorTelp.startsWith("0815")) {
            return "Indosat";
        } else if (nomorTelp.startsWith("0831")) {
            return "Axis";
        } else if (nomorTelp.startsWith("0817")) {
            return "XL";
        } else if (nomorTelp.startsWith("0899")) {
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
                <option value="Paket A">1,5GB 3 Hari</option>
                <option value="Paket B">2,5GB 5 Hari</option>
                <option value="Paket C">5GB 30 Hari</option>
            `;
        } else if (jenisKartu === "Indosat") {
            selectElement.innerHTML += `
                <option value="Paket X">1GB 5 Hari</option>
                <option value="Paket Y">2GB 15 Hari</option>
                <option value="Paket Z">3GB 10 Hari</option>
            `;
        } else if (jenisKartu === "Axis") {
            selectElement.innerHTML += `
                <option value="Paket M">1,5GB 5 Hari</option>
                <option value="Paket N">2GB 5 Hari</option>
                <option value="Paket O">10GB 30 Hari</option>
            `;
        } else if (jenisKartu === "XL") {
            selectElement.innerHTML += `
                <option value="Paket P">2GB 5 Hari</option>
                <option value="Paket Q">4GB 15 Hari</option>
                <option value="Paket R">5GB 30 Hari</option>
            `;
        } else if (jenisKartu === "Three") {
            selectElement.innerHTML += `
                <option value="Paket S">2GB 5 Hari</option>
                <option value="Paket T">6GB 15 Hari</option>
                <option value="Paket U">7GB 30 Hari</option>
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
