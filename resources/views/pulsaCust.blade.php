@extends('layout.customer.maincust')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Pulsa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Pulsa</li>
        </ol>
        <form action="{{ route('pulsaCust.store') }}" method="POST" enctype="multipart/form-data">
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
                <select class="form-select" id="nominal" name="harga" required onchange="updateHarga()">
                    <option value="" data-harga="" selected>-- Pilih Nominal --</option>
                    <option value="12000" data-nominal="10000">Rp 10.000</option>
                    <option value="22000" data-nominal="20000">Rp 20.000</option>
                    <option value="27000" data-nominal="25000">Rp 25.000</option>
                    <option value="52000" data-nominal="50000">Rp 50.000</option>
                    <option value="102000" data-nominal="100000">Rp 100.000</option>
                </select>
            </div>
            <input type="hidden" id="nominal_value" name="nominal"> <!-- Stores the pulse nominal -->            
            <input type="hidden" id="harga" name="harga"> 
            <div class="mb-3">
                <label for="jenis" class="form-label">Tipe Kartu</label>
                <input type="text" class="form-control" id="jenis" name="jenis" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Bayar</button>
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

    function updateHarga() {
    var nominalSelect = document.getElementById("nominal");
    var selectedOption = nominalSelect.options[nominalSelect.selectedIndex];
    var hargaValue = selectedOption.value; // The price (e.g., 12000) for Midtrans
    var nominalValue = selectedOption.getAttribute("data-nominal"); // The nominal (e.g., 10000)

    document.getElementById("harga").value = hargaValue;
    document.getElementById("nominal_value").value = nominalValue;
}
</script>

@endsection