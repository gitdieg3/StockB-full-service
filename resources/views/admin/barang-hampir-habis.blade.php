@extends('admin.main')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-primary">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> Barang Hampir Habis
    </h1>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered m-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Stok</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stokHampirHabis as $barang)
                        <tr>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->jumlah }}</td>
                            <td class="text-center">
                                <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square me-1"></i> Update
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Tidak ada barang hampir habis</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $stokHampirHabis->links() }}
    </div>
</div>
@endsection
