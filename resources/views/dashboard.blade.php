@extends('layout.admin.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-xl-4 col-md-4">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Jumlah Laporan</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('laporan.index') }}">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Jumlah Layanan</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('pulsa.index') }}">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Jumlah Product</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('product.index') }}">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Area Chart
                        </div>
                        <div class="card-body">
                            <canvas id="areaChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Bar Chart
                        </div>
                        <div class="card-body">
                            <canvas id="barChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-comments me-1"></i>
                        Incoming Chats
                    </div>
                    <div class="card-body">
                        <ul id="adminMessages" class="list-group">
                            <!-- New chat messages will be appended here -->
                        </ul>
                    </div>
                </div>
                <div class="card mb -4">
                    <div class="classcard-header">
                        <i class="fas fa-comments me-1"></i>
                        Replay Chat
                    </div>
                    <div class="cardbody">
                        <input type="text" id="adminReplyMessage" class="form-control"
                            placeholder="Type Your Message Here!">
                        <button id="sendReply" class="btn btn-primary mt-3">Send Reply</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        var keuntunganPerBulan = {!! json_encode($keuntunganPerBulan) !!};

        // Debugging: print the data to the console
        console.log("Keuntungan Per Bulan:", keuntunganPerBulan);

        var labels = Object.keys(keuntunganPerBulan).map(function(date) {
            return moment(date, "YYYY-MM").format("MMMM YYYY");
        });

        var totalTransaksiData = Object.values(keuntunganPerBulan).map(function(data) {
            return data.total;
        });

        var pulsaData = Object.values(keuntunganPerBulan).map(function(data) {
            return data.pulsa;
        });

        var paketDataData = Object.values(keuntunganPerBulan).map(function(data) {
            return data.paketData;
        });

        var bayarTagihanData = Object.values(keuntunganPerBulan).map(function(data) {
            return data.bayarTagihan;
        });

        var servicesData = Object.values(keuntunganPerBulan).map(function(data) {
            return data.services;
        });

        var productData = Object.values(keuntunganPerBulan).map(function(data) {
            return data.product;
        });

        document.addEventListener('DOMContentLoaded', function() {
            var areaCtx = document.getElementById('areaChart').getContext('2d');
            var areaChart = new Chart(areaCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Transaksi Perbulan',
                        data: totalTransaksiData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var barCtx = document.getElementById('barChart').getContext('2d');
            var barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Pulsa',
                            data: pulsaData,
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Paket Data',
                            data: paketDataData,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Bayar Tagihan',
                            data: bayarTagihanData,
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Services',
                            data: servicesData,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Product',
                            data: productData,
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Total',
                            data: totalTransaksiData,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        var socket = io('http://localhost:3000');

        // Listen for incoming chat messages
        socket.on('chat', function(msg) {
            console.log(msg);
            var item = document.createElement('li');
            item.innerHTML = `<h5>${msg.sender}</h5><span>${msg.message}</span>`;
            document.getElementById('adminMessages').appendChild(item);
        });
        $('#sendReply').click(function() {
            let adminMessage = $('#adminReplyMessage').val();
            socket.emit('adminReply', {
                sender : 'Admin',
                message : adminMessage
            });
            $('#adminReplayMessage').val('');
        });
        socket.on('chat', function(msg) {
            alert('New message from: ' + msg.sender + '\nMessage: ' + msg.message);
        });
    </script>
@endsection
