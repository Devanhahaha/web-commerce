@extends('layout.customer.maincust')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Detail Pesanan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Detail Pesanan</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Detail Pesanan
            </div>
            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @foreach($product as $product)
                <p><strong>Order ID:</strong> {{ $transaksi->order_id }}</p>
                <p><strong>Status:</strong> {{ $transaksi->status }}</p>
                <p><strong>Jenis Pembayaran:</strong> {{ $transaksi->jenis_pembayaran }}</p>
                <p><strong>Kurir:</strong> {{ $order->kurir }}</p>
                <p><strong>Provinsi:</strong> {{ $order->provinsi }}</p>
                <p><strong>Kabupaten:</strong> {{ $order->kabupaten }}</p>
                <p><strong>Ongkir:</strong> {{ $order->ongkir }}</p>
                <p><strong>Alamat:</strong> {{ $order->alamat }}</p>
                <p><strong>No HP:</strong> {{ $order->no_hp }}</p>
                <p><strong>Catatan:</strong> {{ $order->catatan }}</p>
                <p><strong>Subtotal:</strong> {{ $order->sub_total }}</p>
                <p><strong>Nama Produk:</strong> {{ $product->nama_product }}</p>
                <p><strong>Harga:</strong> {{ $product->nominal }}</p>
                @endforeach
                {{-- @if($transaksi->jenis_pembayaran === 'cod' && $transaksi->status === 'belum di kirim')
                    <form action="{{ route('orders.ship', $transaksi->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Konfirmasi Pesanan</button>
                    </form>
                @endif --}}

                {{-- @if($transaksi->jenis_pembayaran === 'cod' && $transaksi->status === 'sudah di kirim')
                    <form action="{{ route('orders.confirm', $transaksi->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran COD</button>
                    </form>
                @endif --}}
            </div>
        </div>
    </div>
</main>
@endsection
