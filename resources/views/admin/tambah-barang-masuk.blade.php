@extends('admin.main')

@section('content')

<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h4">Form Input Barang</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ isset($barang) ? route('barang.update', $barang->id) : route('barang.store') }}" method="POST">
                @csrf
                @if (isset($barang))
                    @method('PUT')
                @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control"
                               value="{{ old('nama_barang', $barang->nama_barang ?? '') }}"
                               placeholder="Masukkan nama barang" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tipe Barang</label>
                        <select name="tipe_barang_id" class="form-select" required>
                            <option value="">Pilih tipe barang</option>
                            @foreach ($tipes as $tipe)
                                <option value="{{ $tipe->id }}"
                                    {{ old('tipe_barang_id', $barang->tipe_barang_id ?? '') == $tipe->id ? 'selected' : '' }}>
                                    {{ $tipe->nama_tipe }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Merek Barang</label>
                        <input type="text" name="merek_barang" class="form-control"
                               value="{{ old('merek_barang', $barang->merek ?? '') }}"
                               placeholder="Masukkan merek barang" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jumlah Barang</label>
                        <input type="number" name="jumlah_barang" class="form-control"
                               value="{{ old('jumlah_barang', $barang->jumlah ?? '') }}"
                               placeholder="Masukkan jumlah" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status Barang</label>
                        <select name="status_barang_id" class="form-select" required>
                            <option value="">Pilih status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}"
                                    {{ old('status_barang_id', $barang->status_barang_id ?? '') == $status->id ? 'selected' : '' }}>
                                    {{ $status->nama_status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jasa Pengiriman</label>
                        <select name="jasa_kirim_id" class="form-select">
                            <option value="">-- Pilih Jasa Kirim (Opsional) --</option>
                            @foreach ($jasas as $jasa)
                                <option value="{{ $jasa->id }}"
                                    {{ old('jasa_kirim_id', $barang->jasa_kirim_id ?? '') == $jasa->id ? 'selected' : '' }}>
                                    {{ $jasa->nama_jasa }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control"
                               value="{{ old('tanggal_masuk', isset($barang) ? \Carbon\Carbon::parse($barang->tanggal_masuk)->format('Y-m-d') : '') }}"
                               required>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">
                        {{ isset($barang) ? 'Perbarui' : 'Simpan' }}
                    </button>
                    <button class="btn btn-secondary" type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0">Daftar Barang</h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped table-sm mb-0">
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->tipe->nama_tipe ?? '-' }}</td>
                            <td>{{ $barang->merek ?? '-' }}</td>
                            <td>{{ $barang->jumlah }}</td>
                            <td>
                                <span class="badge bg-{{ $barang->status->nama_status == 'Tersedia' ? 'success' : 'danger' }}">
                                    {{ $barang->status->nama_status ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $barang->jasa->nama_jasa ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline show-confirm">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted">Data belum tersedia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
