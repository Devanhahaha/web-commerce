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
                <select class="form-select" id="nominal" name="nominal" required>
                    <option value="12000">Rp 10.000</option>
                    <option value="22000">Rp 20.000</option>
                    <option value="27000">Rp 25.000</option>
                    <option value="52000">Rp 50.000</option>
                    <option value="102000">Rp 100.000</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="jenis" class="form-label">Tipe Kartu</label>
                <input type="text" class="form-control" id="jenis" name="jenis" readonly>
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

    
    document.getElementById("number").addEventListener("input", function() {
        document.getElementById("jenis").value = detectJenisKartu();
    });

    
    document.querySelector('form').addEventListener('submit', function() {
        var nominal = document.getElementById('nominal').value;
        var stokPulsa = 0; 
        var newStok = stokPulsa - parseInt(nominal);
    });
</script>

@endsection