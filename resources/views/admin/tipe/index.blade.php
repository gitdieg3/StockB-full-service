@extends('admin.main')

@section('content')
<div class="container p-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Tipe Barang</h5>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('tipe.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_tipe" class="form-label">Nama Tipe</label>
                    <input type="text" name="nama_tipe" class="form-control" placeholder="Contoh: Elektronik" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <div class="mt-4 card shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0">Daftar Tipe Barang</h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Tipe</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tipes as $tipe)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tipe->nama_tipe }}</td>
                            <td>
                                <a href="{{ route('tipe.edit', $tipe->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('tipe.destroy', $tipe->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($tipes->isEmpty())
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
