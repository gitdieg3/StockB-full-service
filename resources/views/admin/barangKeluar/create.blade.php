@extends('admin.main')

@section('content')
<div class="container-fluid">
    <h4 class="fw-bold text-primary">Tambah Barang Keluar</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('barangKeluar.store') }}" id="barangKeluarForm">
                @csrf
                <div class="mb-3">
                    <label for="barang_id" class="form-label">Nama Barang</label>
                    <select name="barang_id" id="barangSelect" class="form-select" required>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}" data-stok="{{ $barang->jumlah }}"
                                {{ (isset($selectedBarang) && $selectedBarang->id == $barang->id) ? 'selected' : '' }}>
                                {{ $barang->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <strong>Stock Tersedia: <span id="stokTersedia">
                        {{ isset($selectedBarang) ? $selectedBarang->jumlah : $barangs->first()->jumlah }}
                    </span></strong>
                </div>

                <div class="mb-3">
                    <label for="jumlah_keluar" class="form-label">Jumlah Keluar</label>
                    <input type="number" name="jumlah_keluar" id="jumlahKeluar" class="form-control" min="1" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" id="tanggalKeluar" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                    <textarea name="keterangan" class="form-control" rows="2"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('barangKeluar.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const barangSelect = document.getElementById('barangSelect');
        const stokTersedia = document.getElementById('stokTersedia');
        const jumlahKeluar = document.getElementById('jumlahKeluar');
        const tanggalKeluar = document.getElementById('tanggalKeluar');
        const form = document.getElementById('barangKeluarForm');

        // Auto set tanggal ke hari ini
        const today = new Date().toISOString().split('T')[0];
        tanggalKeluar.value = today;

        // Update stok ketika pilih barang
        barangSelect.addEventListener('change', function() {
            const selectedOption = barangSelect.options[barangSelect.selectedIndex];
            stokTersedia.textContent = selectedOption.getAttribute('data-stok');
        });

        // Validasi stok sebelum submit
        form.addEventListener('submit', function(event) {
            const selectedOption = barangSelect.options[barangSelect.selectedIndex];
            const stok = parseInt(selectedOption.getAttribute('data-stok'));
            const jumlah = parseInt(jumlahKeluar.value);

            if (jumlah > stok) {
                event.preventDefault();
                alert('Stock Tidak Cukup! Stok tersedia hanya ' + stok);
                jumlahKeluar.focus();
            }
        });
    });
</script>
@endpush
