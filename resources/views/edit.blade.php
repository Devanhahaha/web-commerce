<!-- resources/views/product/edit.blade.php -->

@extends('layout.admin.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Product</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit Product</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Edit Product
                </div>
                <div class="card-body">
                    <form action="{{ route('product.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Add your form fields here -->
                        <div class="mb-3">
                            <label for="nama_product" class="form-label">Nama Product</label>
                            <input type="text" class="form-control" id="nama_product" name="nama_product" value="{{ $product->nama_product }}">
                        </div>

                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" value="{{ $product->jenis }}">
                        </div>

                        <div class="mb-3">
                            <label for="merk" class="form-label">Merk</label>
                            <input type="text" class="form-control" id="merk" name="merk" value="{{ $product->merk }}">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi">{{ $product->deskripsi }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
