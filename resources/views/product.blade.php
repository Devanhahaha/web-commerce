@extends('layout.admin.main')

@section('css')

@endsection

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
                                    <button type="button" onclick="confirm('{{ $item->id }}')" class="btn btn-danger">Hapus</button>
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

    @section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <script>
        function confirm(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `{{ route('product.delete') }}/`+id //http://......./product-delete/2
                    Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                    });
                }
            });
        }
    </script>
    @endsection