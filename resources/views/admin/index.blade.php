@extends('admin.main')
@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Dashboard Stok Barang</strong></h1>

    <div class="row">
        <!-- Total Barang Masuk -->
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Barang Masuk</h5>
                    <h1 class="mt-1 mb-3">{{ $totalMasuk }}</h1>
                </div>
            </div>
        </div>

        <!-- Total Barang Keluar -->
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Barang Keluar</h5>
                    <h1 class="mt-1 mb-3">{{ $totalKeluar }}</h1>
                </div>
            </div>
        </div>

        <!-- Total Stok Tersedia -->
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Stok Tersedia</h5>
                    <h1 class="mt-1 mb-3">{{ $stokTersedia }}</h1>
                </div>
            </div>
        </div>

        <!-- Barang Hampir Habis -->
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Stok Hampir Habis</h5>
                    <h1 class="mt-1 mb-3">{{ $stokHampirHabis->count() }}</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Pergerakan Barang -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Grafik Barang Masuk & Keluar</h5>
                </div>
                <div class="card-body">
                    <canvas id="grafikStok"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Kalender dan Barang Hampir Habis -->
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Kalender</h5>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Tabel Barang Hampir Habis -->
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Barang Hampir Habis</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stokHampirHabis as $barang)
                            <tr>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>{{ $barang->jumlah }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center">Tidak ada barang hampir habis</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = @json($grafikLabels ?? []);
        const dataMasuk = @json($grafikMasuk ?? []);
        const dataKeluar = @json($grafikKeluar ?? []);

        const ctx = document.getElementById('grafikStok').getContext('2d');
        const grafikStok = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: dataMasuk,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                    },
                    {
                        label: 'Barang Keluar',
                        data: dataKeluar,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                    }
                ]
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: @json($calendarEvents ?? [])
        });
        calendar.render();
    });
</script>
@endpush





