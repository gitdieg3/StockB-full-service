@extends('admin.main')

@section('content')
    <div class="container-fluid">

        <h4 class="fw-bold text-primary mb-4">Barang Keluar</h4>

        {{-- Form Tambah Barang Keluar --}}
        <div class="card mb-4">
            <div class="card-header">Tambah Barang Keluar</div>
            <div class="card-body">
                <form method="POST" action="{{ route('barangKeluar.store') }}" id="barangKeluarForm">
                    @csrf
                    <div class="mb-3">
                        <label for="barangSelect" class="form-label">Nama Barang</label>
                        <select name="barang_id" id="barangSelect" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}" data-stok="{{ $barang->jumlah }}">
                                    {{ $barang->nama_barang }} (Stok: {{ $barang->jumlah }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jumlahKeluar" class="form-label">Jumlah Keluar</label>
                        <input type="number" name="jumlah_keluar" id="jumlahKeluar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggalKeluar" class="form-label">Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" id="tanggalKeluar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-gradient-primary">Simpan</button>
                    <a href="{{ route('barangKeluar.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>

        {{-- Tabel Riwayat Barang Keluar --}}


        <div class="card-header">Riwayat Barang Keluar
            <div class="mb-3 text-end">
                <a href="{{ route('barangKeluar.exportExcel') }}" class="btn btn-success btn-sm">Export Excel</a>
                <a href="{{ route('barangKeluar.exportPdf') }}" class="btn btn-danger btn-sm">Export PDF</a>
                <button onclick="window.print()" class="btn btn-primary btn-sm">Print</button>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Keluar</th>
                                <th>Tanggal Keluar</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangKeluars as $keluar)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $keluar->barang->nama_barang ?? '-' }}</td>
                                    <td>{{ $keluar->jumlah_keluar }}</td>
                                    <td>{{ \Carbon\Carbon::parse($keluar->tanggal_keluar)->format('d M Y') }}</td>
                                    <td>{{ $keluar->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada barang keluar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $barangKeluars->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Auto isi tanggal hari ini
        document.getElementById('tanggalKeluar').valueAsDate = new Date();

        // Cek stok sebelum submit
        document.getElementById('barangKeluarForm').addEventListener('submit', function (e) {
            let barangSelect = document.getElementById('barangSelect');
            let selectedOption = barangSelect.options[barangSelect.selectedIndex];
            let stok = parseInt(selectedOption.getAttribute('data-stok') || 0);
            let jumlahKeluar = parseInt(document.getElementById('jumlahKeluar').value);

            if (jumlahKeluar > stok) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Stok Tidak Cukup!',
                    text: 'Jumlah keluar melebihi stok yang tersedia.'
                });
            }
        });

        // SweetAlert untuk pesan sukses/error dari session
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endpush