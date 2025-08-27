@extends('admin.main')
@section('content')
    <div class="container-fluid p-4">
        <h1 class="text-2xl font-bold mb-6">Dashboard Analisis</h1>

        <!-- Filter Section -->
        <div class="flex flex-col w-48">
            <label class="text-sm font-semibold mb-1">Kategori</label>
            <select id="filterKategori" class="border rounded-md text-sm px-2 py-1">
                <option value="">Semua</option>
                @foreach ($kategoriList as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama_tipe }}</option>
                @endforeach
            </select>
        </div>

        <!-- Ringkasan Statistik -->
        <div class="row mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Barang Masuk</h5>
                        <h1 class="mt-1 mb-3" id="totalMasuk">{{ $totalMasuk }}</h1>
                        <div class="mb-0 text-muted">Sejak minggu lalu:
                            <span class="text-danger">-3.65%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Barang Keluar</h5>
                        <h1 class="mt-1 mb-3" id="totalKeluar">{{ $totalKeluar }}</h1>
                        <div class="mb-0 text-muted">Sejak minggu lalu:
                            <span class="text-success">+5.25%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Growth % Bulanan</h5>
                        <h1 class="mt-1 mb-3">
                            @if ($growthPercent >= 0)
                                <span class="text-success">+{{ $growthPercent }}%</span>
                            @else
                                <span class="text-danger">{{ $growthPercent }}%</span>
                            @endif
                        </h1>
                        <div class="mb-0 text-muted">Sejak minggu lalu: +6.65%</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top Barang Keluar</h5>
                        <h1 class="mt-1 mb-3">{{ $totalKeluar }}</h1>
                        <div class="mb-0 text-muted">Sejak minggu lalu: -2.25%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Line -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Grafik Pergerakan Barang</h5>
                    </div>
                    <div class="card-body" style="height: 400px;">
                        <canvas id="lineChart" class="w-100 h-100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top pe adata  -->
        <div class="row mb-4">


            <!-- Pie Chart -->
            <div class="col-12 col-xl-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Distribusi Barang</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <canvas id="pieChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
            <!-- Tchart -->
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Bar Chart</h5>
                        <h6 class="card-subtitle text-muted">
                            A bar chart provides a way of
                            showing data values represented as
                            vertical bars.
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="chartjs-bar"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Top Barang Keluar List -->
        <div>
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Top Barang Dibeli</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($topBarangKeluar as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item->barang->nama_barang }}
                                    <span class="badge bg-primary rounded-pill">{{ $item->total_keluar }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Line Chart
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: @json($grafikLabels),
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: @json($grafikMasuk),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Barang Keluar',
                        data: @json($grafikKeluar),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Pie Chart
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: @json($pieLabels),
                datasets: [{
                    data: @json($pieCounts),
                    backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Optional Realtime Polling
        setInterval(() => {
            fetch("{{ route('analytics.realtime') }}")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalMasuk').innerText = data.totalMasuk;
                    document.getElementById('totalKeluar').innerText = data.totalKeluar;
                });
        }, 5000);
    </script>
     <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Line chart
                new Chart(document.getElementById("chartjs-line"), {
                    type: "line",
                    data: {
                        labels: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sep",
                            "Oct",
                            "Nov",
                            "Dec",
                        ],
                        datasets: [
                            {
                                label: "Sales ($)",
                                fill: true,
                                backgroundColor: "transparent",
                                borderColor: window.theme.primary,
                                data: [
                                    2115, 1562, 1584, 1892, 1487, 2223, 2966,
                                    2448, 2905, 3838, 2917, 3327,
                                ],
                            },
                            {
                                label: "Orders",
                                fill: true,
                                backgroundColor: "transparent",
                                borderColor: "#adb5bd",
                                borderDash: [4, 4],
                                data: [
                                    958, 724, 629, 883, 915, 1214, 1476, 1212,
                                    1554, 2128, 1466, 1827,
                                ],
                            },
                        ],
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: {
                            display: false,
                        },
                        tooltips: {
                            intersect: false,
                        },
                        hover: {
                            intersect: true,
                        },
                        plugins: {
                            filler: {
                                propagate: false,
                            },
                        },
                        scales: {
                            xAxes: [
                                {
                                    reverse: true,
                                    gridLines: {
                                        color: "rgba(0,0,0,0.05)",
                                    },
                                },
                            ],
                            yAxes: [
                                {
                                    ticks: {
                                        stepSize: 500,
                                    },
                                    display: true,
                                    borderDash: [5, 5],
                                    gridLines: {
                                        color: "rgba(0,0,0,0)",
                                        fontColor: "#fff",
                                    },
                                },
                            ],
                        },
                    },
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Bar chart
                new Chart(document.getElementById("chartjs-bar"), {
                    type: "bar",
                    data: {
                        labels: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sep",
                            "Oct",
                            "Nov",
                            "Dec",
                        ],
                        datasets: [
                            {
                                label: "Last year",
                                backgroundColor: window.theme.primary,
                                borderColor: window.theme.primary,
                                hoverBackgroundColor: window.theme.primary,
                                hoverBorderColor: window.theme.primary,
                                data: [
                                    54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48,
                                    79,
                                ],
                                barPercentage: 0.75,
                                categoryPercentage: 0.5,
                            },
                            {
                                label: "This year",
                                backgroundColor: "#dee2e6",
                                borderColor: "#dee2e6",
                                hoverBackgroundColor: "#dee2e6",
                                hoverBorderColor: "#dee2e6",
                                data: [
                                    69, 66, 24, 48, 52, 51, 44, 53, 62, 79, 51,
                                    68,
                                ],
                                barPercentage: 0.75,
                                categoryPercentage: 0.5,
                            },
                        ],
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: {
                            display: false,
                        },
                        scales: {
                            yAxes: [
                                {
                                    gridLines: {
                                        display: false,
                                    },
                                    stacked: false,
                                    ticks: {
                                        stepSize: 20,
                                    },
                                },
                            ],
                            xAxes: [
                                {
                                    stacked: false,
                                    gridLines: {
                                        color: "transparent",
                                    },
                                },
                            ],
                        },
                    },
                });
            });
        </script>
@endpush