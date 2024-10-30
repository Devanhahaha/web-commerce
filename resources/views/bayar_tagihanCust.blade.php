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
                <select class="form-select" id="nominal" name="nominal" required>
                    <option value="23000">Rp 20.000 - Harga: Rp 23.000</option>
                    <option value="53000">Rp 50.000 - Harga: Rp 53.000</option>
                    <option value="103000">Rp 100.000 - Harga: Rp 103.000</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Bayar</button>
        </form>
    </div>
</main>
@endsection
