@extends('layout.customer.maincust')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Keranjang Belanja</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Cart</li>
            </ol>
            @if (session()->has('cart') && count(session('cart')) > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-shopping-cart me-1"></i>
                        List Produk di Keranjang
                    </div>
                    @if (session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('productCust.checkoutCart') }}" method="POST">
                            @csrf
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Pilih</th>
                                        <th>No.</th>
                                        <th>Gambar</th>
                                        <th>Nama Product</th>
                                        <th>Jenis</th>
                                        <th>Merk</th>
                                        <th>Quantity</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(collect(session('cart'))->filter(function($value, $key){
                                        return strpos($value['user_id'], Auth::user()->id) === 0;
                                    })->all() as $id => $details)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="selected_products[]"
                                                    value="{{ $id }}">
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ asset($details['gambar']) }}" alt="gambar"
                                                    style="max-width: 100px"></td>
                                            <td>{{ $details['nama_product'] }}</td>
                                            <td>{{ $details['jenis'] }}</td>
                                            <td>{{ $details['merk'] }}</td>
                                            <td>
                                                <div class="quantity-controls">
                                                    <form action="{{ route('cart.update', $id) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        <input type="hidden" name="action" value="decrease">
                                                        {{-- <button type="submit" class="btn btn-warning">-</button> --}}
                                                    </form>
                                                    <form action="{{ route('cart.update', $id) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        <input type="hidden" name="action" value="decrease">
                                                        <button type="submit" class="btn btn-warning">-</button>
                                                    </form>
                                                    <span>{{ $details['quantity'] }}</span>
                                                    <form action="{{ route('cart.update', $id) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        <input type="hidden" name="action" value="increase">
                                                        <button type="submit" class="btn btn-success">+</button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>{{ $details['nominal'] }}</td>
                                            <td>
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9">Keranjang Anda kosong!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <button class="btn btn-success">Proceed to Checkout</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info">Keranjang Anda kosong!</div>
            @endif
        </div>
    </main>
@endsection
