<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Tipe</th>
            <th>Merek</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Jasa</th>
            <th>Tanggal Masuk</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangs as $barang)
        <tr>
            <td>{{ $barang->nama_barang }}</td>
            <td>{{ $barang->tipe->nama_tipe ?? '-' }}</td>
            <td>{{ $barang->merek }}</td>
            <td>{{ $barang->jumlah }}</td>
            <td>{{ $barang->status->nama_status ?? '-' }}</td>
            <td>{{ $barang->jasa->nama_jasa ?? '-' }}</td>
            <td>{{ $barang->tanggal_masuk }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
