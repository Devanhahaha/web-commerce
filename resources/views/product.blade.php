@extends('layout.admin.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Product</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Product</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                List Product
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('product.create') }}" class="btn btn-primary mb-4">Tambah Product</a>
                    </div>
                </div>
                <table class="text-center" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Gambar</th>
                            <th>Nama Product</th>
                            <th>Jenis</th>
                            <th>Merk</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->gambar }}</td>
                                <td>{{ $item->nama_product }}</td>
                                <td>{{ $item->jenis }}</td>
                                <td>{{ $item->merk }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>
                                    <a href="{{ route('product.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                    <a href="{{ route('product.delete', $item->id) }}" class="btn btn-danger">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    @endsection