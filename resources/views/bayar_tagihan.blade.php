@extends('layout.admin.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Bayar Tagihan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Bayar Tagihan</li>
        </ol>
        <form action="{{ route('bayar_tagihan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="jenis_tagihan" class="form-label">Pilih Jenis Tagihan</label>
                <select class="form-select" id="jenis_tagihan" name="jenis_tagihan" required>
                    <option value="">Pilih Jenis Tagihan</option>
                    <option value="PLN">Tagihan Listrik PLN</option>
                    <option value="BPJS">Tagihan Kartu BPJS</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="nomor_tagihan" class="form-label">Nomor Tagihan</label>
                <input type="text" class="form-control" id="nomor_tagihan" name="nomor_tagihan" required>
            </div>
            <div class="mb-3">
                <label for="nominal" class="form-label">Nominal</label>
                <input type="number" class="form-control" id="nominal" name="nominal" required>
            </div>
            <button type="submit" class="btn btn-primary">Bayar</button>
        </form>
    </div>
</main>
@endsection
