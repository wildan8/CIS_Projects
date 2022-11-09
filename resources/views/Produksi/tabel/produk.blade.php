@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Master Produk</h1>
    </div>
    @if (session()->has('statusProduk'))
    <div class="alert alert-success">
        {{ session('statusProduk') }}
    </div>
    @endif
    @if (session()->has('hapusProduk'))
    <div class="alert alert-success">
        {{ session('hapusProduk') }}
    </div>
    @endif
    @if (session()->has('updateProduk'))
    <div class="alert alert-success">
        {{ session('updateProduk') }}
    </div>
    @endif
    <div>
        <a href="/produk/createPROD" class="btn btn-icon icon-right  m-2 btn-primary"><i class="far fa-edit"></i> Tambah Data</a>
        <a href="/produk/export" class="btn btn-icon icon-right  m-2 btn-danger"> Export
            Data</a>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="table-responsive p-2">
                <table class="table table-striped table-md">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Ukuran Produk</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $produk)
                        <tr>
                            <td>{{ $produk->ID_Produk }}</td>
                            <td>
                                @if (strlen($produk->Nama_Produk) >= 20)
                                {{ substr($produk->Nama_Produk, 0, 20) . '...' }}
                                @else
                                {{ $produk->Nama_Produk }}
                                @endif
                            </td>
                            <td>{{ $produk->Ukuran_Produk }}</td>
                            <td>{{ $produk->Jumlah_Produk }}</td>

                            <td>
                                <a href="/produk/editPROD/{{ $produk->ID_Produk }}" class="btn btn-icon  m-2 btn-primary"><i class="far fa-edit"></i></a>
                                <a href="/produk/deletePROD/{{ $produk->ID_Produk }}" class="btn btn-icon  m-2 btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="section-body">
    </div>
</section>
@endsection
