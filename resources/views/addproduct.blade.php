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
                        {{-- Form for adding product --}}
                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @foreach ($fields as $field)
                                <div class="mb-3">
                                    <label for="{{ $field['id'] }}" class="form-label">{{ $field['label'] }}</label>
                                    <input 
                                        type="{{ $field['type'] }}" 
                                        class="form-control" 
                                        id="{{ $field['id'] }}" 
                                        name="{{ $field['name'] }}" 
                                        {{ $field['required'] ? 'required' : '' }}
                                    >
                                </div>
                            @endforeach
                            {{-- File input for image --}}
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" accept=".png, .jpg, .jpeg, .svg, .webp" class="form-control" id="gambar" name="gambar" required>
                            </div>
                            {{-- Submit button --}}
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection