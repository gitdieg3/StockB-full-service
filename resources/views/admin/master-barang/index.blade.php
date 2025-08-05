@extends('admin.main')

@section('content')
    <div class="container p-4">
        <div class="row">
        <p>peringatan hati hati dalam penghapusan,di sarankn jangn di hapus ,telilito sebelum membuat keren akan mengkibatkn fatal</p>
            <!-- Form Tipe Barang -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Tambah Tipe Barang</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('master.storeTipe') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Tipe</label>
                                <input type="text" name="nama_tipe" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Daftar Tipe Barang</h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tipes as $tipe)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $tipe->nama_tipe }}</td>
                                        <td>
                                            <form action="{{ route('master.deleteTipe', $tipe->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm show-confirm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Form Status Barang -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">Tambah Status Barang</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('master.storeStatus') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Status</label>
                                <input type="text" name="nama_status" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm">Tambah</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Daftar Status Barang</h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($statuses as $status)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $status->nama_status }}</td>
                                        <td>
                                            <form action="{{ route('master.deleteStatus', $status->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm show-confirm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Form jasa kirim Barang -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0">Tambah Jasa Pengirim Barang</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('master.storeJasa') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Jasa Pengirim</label>
                                <input type="text" name="nama_jasa" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-danger btn-sm">Tambah</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Daftar Jasa Kirim Barang</h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Jasa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jasas as $jasa)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jasa->nama_jasa }}</td>
                                        <td>
                                            <form action="{{ route('master.deleteJasa', $jasa->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm show-confirm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada data</td>
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