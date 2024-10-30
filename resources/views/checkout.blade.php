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
                    @foreach ($co as $item)
                        <input type="hidden" name="product_id[]" value="{{ $item['id'] }}">
                        <input type="hidden" name="quantity[]" value="{{ $item['quantity'] }}">
                        <input type="hidden" name="sub_total[]" value="{{ $item['nominal'] * $item['quantity'] }}">
                    @endforeach

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
                        <label for="provinsi" class="form-label">Provinsi</label>
                        <select class="form-control" id="provinsi" name="provinsi" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                        <select class="form-control" id="kabupaten" name="kabupaten" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="ongkir" class="form-label">Ongkir</label>
                        <input type="text" class="form-control" id="ongkir" name="ongkir" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Informasi Tambahan</label>
                        <textarea class="form-control" id="catatan" name="catatan"></textarea>
                    </div>
                    @foreach ($co as $item)  
                        <div class="mb-3">
                            <img src="{{ asset($item['gambar']) }}" style="max-width: 100px">
                            <strong>Nama Product:</strong> {{ $item['nama_product'] }}<br>
                            <strong>Jenis Product:</strong> {{ $item['jenis'] }}<br>
                            <strong>Merk:</strong> {{ $item['merk'] }}<br>
                            <strong>Deskripsi:</strong> {{ $item['deskripsi'] }}<br>
                            <strong>Nominal:</strong> {{ $item['nominal'] }}<br>
                            <strong>Quantity:</strong> {{ $item['quantity'] }}<br>
                            <strong>Total:</strong> {{ $item['nominal'] * $item['quantity'] }}<br>
                        </div>
                    @endforeach
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

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Load Provinces from Raja Ongkir API
        $.ajax({
            url: '/getProvinsi',
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('#provinsi').empty().append('<option value="">Pilih Provinsi</option>');
                $.each(data.rajaongkir.results, function(key, value) {
                    $('#provinsi').append('<option value="' + value.province_id + '">' + value.province + '</option>');
                });
            }
        });

        // Load Kabupaten based on selected Provinsi
        $('#provinsi').on('change', function() {
            var provinsiID = $(this).val();
            if (provinsiID) {
                $.ajax({
                    url: '/getKabupaten/' + provinsiID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#kabupaten').empty().append('<option value="">Pilih Kabupaten/Kota</option>');
                        $.each(data.rajaongkir.results, function(key, value) {
                            $('#kabupaten').append('<option value="' + value.city_id + '">' + value.city_name + '</option>');
                        });
                    }
                });
            } else {
                $('#kabupaten').empty().append('<option value="">Pilih Kabupaten/Kota</option>');
                $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                $('#desa').empty().append('<option value="">Pilih Desa</option>');
            }
        });

        // Load Kecamatan based on selected Kabupaten
        $('#kabupaten').on('change', function() {
            var kabupatenID = $(this).val();
            // Ambil data kecamatan berdasarkan API atau database Anda
        });

        // Load Desa based on selected Kecamatan
        $('#kecamatan').on('change', function() {
            var kecamatanID = $(this).val();
            // Ambil data desa berdasarkan API atau database Anda
        });
        $('#kabupaten').on('change', function() {
    var kabupatenID = $(this).val();
    var kecamatanID = $('#kecamatan').val(); // Assuming you have kecamatan selected
    var berat = 1000; // Set the weight of your product in grams (adjust as needed)
    var kurir = $('#kurir').val();

    if(kabupatenID) {
        $.ajax({
            url: '/getOngkir',
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                kabupaten: kabupatenID,
                kecamatan: kecamatanID,
                berat: berat,
                kurir: kurir
            },
            success: function(data) {
                $('#ongkir').val(data.ongkir);
            }
        });

    }
});
    });
</script>
@endsection
