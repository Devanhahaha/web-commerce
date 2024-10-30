@extends('layout.customer.maincust')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Service</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Service</li>
        </ol>
        <form action="{{ route('serviceCust.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
            <div class="mb-3">
                <label for="number" class="form-label">Jenis Hp</label>
                <input type="text" class="form-control" id="jenis" name="jenis" required>
            </div>
            <div class="mb-3">
                <label for="jenis" class="form-label">Deskripsi Keluhan</label>
                <input type="text" class="form-control" id="keluhan" name="keluhan" required>
            </div>
            <div class="mb-3">
                <label for="nominal" class="form-label">Kontak</label>
                <input type="text" class="form-control" id="number" name="number" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>
@endsection
