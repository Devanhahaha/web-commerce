@extends('layout.customer.maincust')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Checkout</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Checkout Product
            </div>
            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $productcust->id }}">

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Informasi Tambahan</label>
                        <textarea class="form-control" id="catatan" name="catatan"></textarea>
                    </div>
                    <div class="mb-3">
                        <img src="{{ asset($productcust->gambar) }}" style="max-width: 100px">
                        <strong>Nama Product:</strong> {{ $productcust->nama_product }}<br>
                        <strong>Jenis Product:</strong> {{ $productcust->jenis }}<br>
                        <strong>Merk:</strong> {{ $productcust->merk }}<br>
                        <strong>Deskripsi:</strong> {{ $productcust->deskripsi }}<br>
                        <strong>Nominal:</strong> {{ $productcust->nominal }}<br>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="online">Online</option>
                            <option value="cod">Cash on Delivery (COD)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Pesan</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
