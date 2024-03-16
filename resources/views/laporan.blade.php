@extends('layout.admin.main')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Laporan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Laporan</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                DataTable Example
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Nomor Telp</th>
                            <th>Nominal</th>
                            <th>Jenis Layanan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection