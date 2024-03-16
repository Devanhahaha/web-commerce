@extends('layout.admin.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Pulsa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Pulsa</li>
        </ol>
        <form action="{{ route('pulsa.store') }}" method="POST" enctype="multipart/form-data">
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
                <label for="nominal" class="form-label">Nominal</label>
                <input type="text" class="form-control" id="nominal" name="nominal" required>
            </div>
            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis Kartu</label>
                <input type="text" class="form-control" id="jenis" name="jenis" readonly>
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

    // Setel jenis kartu pelanggan saat input nomor telepon berubah
    document.getElementById("number").addEventListener("input", function() {
        document.getElementById("jenis").value = detectJenisKartu();
    });
</script>

@endsection
