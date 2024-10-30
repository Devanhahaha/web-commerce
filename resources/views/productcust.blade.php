@extends('layout.customer.maincust')

@section('css')
<style>
   
</style>
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
                @if(session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <table class="text-center" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Gambar</th>
                            <th>Nama Product</th>
                            <th>Jenis</th>
                            <th>Merk</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Quantity</th> <!-- Align the quantity here -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productCust as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ asset($item->gambar) }}" style="max-width: 100px"></td>
                                <td>{{ $item->nama_product }}</td>
                                <td>{{ $item->jenis }}</td>
                                <td>{{ $item->merk }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>{{ $item->nominal }}</td>
                                <td>{{ $item->stok }}</td>

                                <!-- Quantity input controls -->
                                <td>
                                    <div class="quantity-controls">
                                        <button type="button" class="btn btn-warning" onclick="decreaseQuantity({{ $item->id }})">-</button>
                                        <span id="quantity-{{ $item->id }}">{{ $item->quantity ?? 1 }}</span> <!-- Display actual quantity -->
                                        <input type="hidden" name="quantity[{{ $item->id }}]" id="quantity-input-{{ $item->id }}" value="{{ $item->quantity ?? 1 }}">
                                        <button type="button" class="btn btn-success" onclick="increaseQuantity({{ $item->id }}, {{ $item->stok }})">+</button>
                                    </div>                                    
                                </td>
                                <!-- Action buttons -->
                                <td>
                                    <div class="action-buttons">
                                        <!-- Add to Cart Button (No Quantity Selection) -->
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                                        </form>

                                        <!-- Checkout Button with Quantity Selection -->
                                        <form action="{{ route('productCust.checkout', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-warning">Checkout</button>
                                        </form>
                                    </div>
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

<script>
    function increaseQuantity(productId, maxStock) {
        let quantitySpan = document.getElementById(`quantity-${productId}`);
        let quantityInput = document.getElementById(`quantity-input-${productId}`);
        let currentQuantity = parseInt(quantitySpan.innerText);

        if (currentQuantity < maxStock) {
            quantitySpan.innerText = currentQuantity + 1;
            quantityInput.value = currentQuantity + 1;
        } else {
            alert('Stok tidak mencukupi!');
        }
    }

    function decreaseQuantity(productId) {
        let quantitySpan = document.getElementById(`quantity-${productId}`);
        let quantityInput = document.getElementById(`quantity-input-${productId}`);
        let currentQuantity = parseInt(quantitySpan.innerText);

        if (currentQuantity > 1) {
            quantitySpan.innerText = currentQuantity - 1;
            quantityInput.value = currentQuantity - 1;
        }
    }
</script>