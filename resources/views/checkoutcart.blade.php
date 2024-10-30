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
                Checkout Produk
            </div>
            <div class="card-body">
                @if(session()->has('selectedItems'))
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="kurir" class="form-label">Kurir</label>
                            <select class="form-control" id="kurir" name="kurir" required>
                                <option value="">Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Pengiriman</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        
                        @php
                            $selectedItems = session('selectedItems');
                            $total = 0;
                        @endphp
                        
                        <h4>Produk yang akan di-checkout:</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selectedItems as $id => $details)
                                    <tr>
                                        <td>{{ $details['nama_product'] }}</td>
                                        <td>{{ $details['quantity'] }}</td>
                                        <td>{{ $details['nominal'] }}</td>
                                    </tr>
                                    @php $total += $details['nominal'] * $details['quantity']; @endphp
                                @endforeach
                            </tbody>
                        </table>

                        <h4>Total: Rp {{ number_format($total, 0, ',', '.') }}</h4>
                        <input type="hidden" name="total_amount" value="{{ $total }}">
                        
                        <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                    </form>
                @else
                    <div class="alert alert-info">Tidak ada produk yang dipilih untuk checkout!</div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
