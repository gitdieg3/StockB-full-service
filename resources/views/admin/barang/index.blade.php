@extends('admin.main')

@section('content')
    <div class="container-fluid">
        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: @json(session('success')),
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
        @endif

        <div class="d-flex justify-content-between flex-wrap mb-4 items-center">
            <h4 class="fw-bold text-primary">Data Barang</h4>
            <a href="{{ route('tambahData') }}" class="btn btn-gradient-primary shadow-sm">
                + Tambah Barang
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <!-- Search & Filter -->
                <form method="GET" action="{{ route('barang.index') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Cari Nama Barang">
                        </div>
                        <div class="col-md-3">
                            <select name="tipe" class="form-select">
                                <option value="">Semua Tipe</option>
                                @foreach ($tipes as $tipe)
                                    <option value="{{ $tipe->id }}" {{ request('tipe') == $tipe->id ? 'selected' : '' }}>
                                        {{ $tipe->nama_tipe }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                        {{ $status->nama_status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="jasa_pengiriman" value="{{ request('jasa_pengiriman') }}"
                                class="form-control" placeholder="Jasa Pengiriman">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
                        <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                    </div>
                </form>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Total Barang: </strong> {{ $totalBarang }}
                    </div>
                    <div class="col-md-4">
                        <strong>Tanggal: </strong>
                        {{ request('start_date') ?? '-' }} - {{ request('end_date') ?? '-' }}
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('barang.exportExcel', request()->query()) }}"
                            class="btn btn-success btn-sm">Export Excel</a>
                        <a href="{{ route('barang.exportPdf', request()->query()) }}" class="btn btn-danger btn-sm">Export
                            PDF</a>
                    </div>
                </div>

                <!-- Tabel data -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Merek</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Jasa Pengiriman</th>
                                <th>Tanggal Masuk</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangs as $barang)
                                <tr>
                                    <td>{{ $loop->iteration + ($barangs->currentPage() - 1) * $barangs->perPage() }}</td>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->tipe->nama_tipe ?? '-' }}</td>
                                    <td>{{ $barang->merek ?? '-' }}</td>
                                    <td>{{ $barang->jumlah }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $barang->status->nama_status == 'New' ? 'success' : 'danger' }}">
                                            {{ $barang->status->nama_status ?? '-' }}
                                        </span>
                                    </td>
                                    <td>{{ $barang->jasa?->nama_jasa ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('barangKeluar.create', ['barang_id' => $barang->id]) }}"
                                            class="btn btn-sm btn-warning">
                                            Barang Keluar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Data belum tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $barangs->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection