@extends('layout.customer.maincust')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Bayar Tagihan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Bayar Tagihan</li>
        </ol>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bayar_tagihanCust.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label for="jenis_tagihan" class="form-label">Pilih Jenis Tagihan</label>
                <select class="form-select" id="jenis_tagihan" name="jenis_tagihan" required>
                    <option value="">Pilih Jenis Tagihan</option>
                    <option value="PLN" {{ old('jenis_tagihan') == 'PLN' ? 'selected' : '' }}>Tagihan Listrik PLN</option>
                    <option value="BPJS" {{ old('jenis_tagihan') == 'BPJS' ? 'selected' : '' }}>Tagihan Kartu BPJS</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="nomor_tagihan" class="form-label">Nomor Tagihan</label>
                <input type="text" class="form-control" id="nomor_tagihan" name="nomor_tagihan" required value="{{ old('nomor_tagihan') }}">
            </div>
            <div class="mb-3">
                <label for="nominal" class="form-label">Nominal</label>
                <select class="form-select" id="nominal" name="harga" required onchange="updateHarga()">
                    <option value="23000" data-nominal="20000">Rp 20.000</option>
                    <option value="53000" data-nominal="50000">Rp 50.000</option>
                    <option value="103000" data-nominal="100000">Rp 100.000</option>
                </select>
            </div>
            <input type="hidden" id="nominal_value" name="nominal">
            <input type="hidden" id="harga" name="harga"> 
            <button type="submit" class="btn btn-primary">Bayar</button>
        </form>
    </div>
</main>
<script>
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
