@extends('admin.main')

@section('content')
<div class="container">
    <h1>Barang Hampir Habis</h1>
    <table class="table">
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
                    <td colspan="2">Tidak ada barang hampir habis</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $stokHampirHabis->links() }}
</div>
@endsection
