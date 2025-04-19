@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-car"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Mobil</span>
                            <span class="info-box-number">
                                {{ $jumlahTersedia }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Sales</span>
                            <span class="info-box-number">{{ $jumlahSales }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Pendapatan</span>
                            <span class="info-box-number">Rp
                              {{ number_format($totalUangDihasilkan, 0, ',', '.') }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-sign-out-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Mobil Terjual</span>
                            <span class="info-box-number">{{ $jumlahSold }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row mb-4">
                <!-- Data Mobil Booking -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-warning">
                            <h5>Data Mobil Booking</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover table-sm" id="table-booking">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Sales</th>
                                        <th>Type</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Pembeli</th>
                                        <th>No Telp Sales</th>
                                        <th>No Telp Pembeli</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Data Mobil Sold -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-danger">
                            <h5>Data Mobil Lunas atau Sold</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover table-sm" id="table-sold">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Sales</th>
                                        <th>Type</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Pembeli</th>
                                        <th>No Telp Sales</th>
                                        <th>No Telp Pembeli</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Chart Mobil Data (Bar Chart) -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h5>Chart Mobil Data</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 542px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart Data -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-success">
                            <h5>Pie Chart Data</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 542px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Uang yang Dihasilkan -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5>Total Uang yang Dihasilkan dari Penjualan</h5>
                        </div>
                        <div class="card-body">
                            <p>Total Uang yang Dihasilkan: <strong>Rp
                                    {{ number_format($totalUangDihasilkan, 0, ',', '.') }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function initTable(id, status) {
            $('#' + id).DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('laporan/data') }}",
                    type: "GET",
                    data: {
                        status: status
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "user.username"
                    },
                    {
                        data: "mobil.type"
                    },
                    {
                        data: "mobil.harga"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "pembeli"
                    },
                    {
                        data: "user.telp"
                    },
                    {
                        data: "telp_pembeli"
                    }
                ]
            });
        }

        $(document).ready(function() {
            const tables = [{
                    id: 'table-booking',
                    status: 'Booking'
                },
                {
                    id: 'table-sold',
                    status: 'Sold'
                }
            ];

            tables.forEach(function(tbl) {
                initTable(tbl.id, tbl.status);
            });
        });

        const areaChartData = {
            labels: ['Booking', 'Sold', 'Tersedia'],
            datasets: [{
                label: 'Data Jumlah Mobil',
                backgroundColor: ['#f39c12', '#c0392b', '#00a65a'], // warna: orange booking, hijau sold
                data: [{{ $jumlahBooking }}, {{ $jumlahSold }}, {{ $jumlahTersedia }}]
            }]
        };

        // Define the donutData (Pie Chart Data)
        const donutData = {
            labels: ['Booking', 'Sold', 'Tersedia'],
            datasets: [{
                data: [{{ $jumlahBooking }}, {{ $jumlahSold }},
                {{ $jumlahTersedia }}], // Use the same data for the pie chart
                backgroundColor: ['#f39c12', '#c0392b', '#00a65a']
            }]
        };

        $(function() {
            // Bar Chart
            var barChartCanvas = $('#barChart').get(0).getContext('2d');
            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false,
                scales: {
                    y: {
                        beginAtZero: true, // Y-axis mulai dari 0
                        ticks: {
                            stepSize: 1,
                            suggestedMax: 10
                        }
                    }
                }
            };

            new Chart(barChartCanvas, {
                type: 'bar',
                data: areaChartData,
                options: barChartOptions
            });

            // Pie Chart
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            };

            new Chart(pieChartCanvas, {
                type: 'pie',
                data: donutData,
                options: pieOptions
            });
        });
    </script>
@endpush
