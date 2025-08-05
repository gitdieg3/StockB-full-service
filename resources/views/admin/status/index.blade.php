@extends('admin.main')

@section('content')
<div class="container p-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Tambah Status Barang</h5>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('status.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Status</label>
                    <input type="text" name="nama_status" class="form-control" placeholder="Contoh: Tersedia, Rusak, Dipinjam" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>

    <div class="mt-4 card shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0">Daftar Status Barang</h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($statuses as $status)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $status->nama_status }}</td>
                            <td>
                                <a href="{{ route('status.edit', $status->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('status.destroy', $status->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($statuses->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
