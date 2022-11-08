@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Master Bahan Baku</h1>
    </div>
    @if (session()->has('statusBahanBaku'))
    <div class="alert alert-success">
        {{ session('statusBahanBaku') }}
    </div>
    @endif
    @if (session()->has('hapusBahanBaku'))
    <div class="alert alert-danger">
        {{ session('hapusBahanBaku') }}
    </div>
    @endif
    @if (session()->has('updateBahanBaku'))
    <div class="alert alert-success">
        {{ session('updateBahanBaku') }}
    </div>
    @endif
    <div>
        <a href="/Bahanbaku/createBB" class="btn btn-icon icon-left btn-primary m-2"><i class="far fa-edit"></i> Tambah
            Data</a>
    </div>
    <div>
        <a href="/Bahanbaku/export" class="btn btn-icon icon-left btn-primary m-2"><i class="far fa-edit"></i> Export
            Data</a>
    </div>
    <div class="section-body">

        <div class="card table-responsive p-2">
            <table class="table table-striped table-md ">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Stok</th>
                        <th scope="col">harga Satuan</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bahanbaku as $bahanbaku)
                    <tr>
                        <td>{{ $bahanbaku->ID_BahanBaku }}</td>
                        <td>
                            @if (strlen($bahanbaku->Nama_BahanBaku) > 20)
                            {{ substr($bahanbaku->Nama_BahanBaku, 0, 20) . '...' }}
                            @else
                            {{ $bahanbaku->Nama_BahanBaku }}
                            @endif
                        </td>
                        <td>{{ $bahanbaku->Stok_BahanBaku }}</td>
                        <td>{{ $bahanbaku->Harga_Satuan }}</td>
                        <td>
                            @if (strlen($bahanbaku->supplier->Nama_Supplier) > 10)
                            {{ substr($bahanbaku->supplier->Nama_Supplier, 0, 10) . '...' }}
                            @else
                            {{ $bahanbaku->supplier->Nama_Supplier }}
                            @endif
                        <td>
                            <a href="/Bahanbaku/editBB/{{ $bahanbaku->ID_BahanBaku }}" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                            <a href="/Bahanbaku/deleteBB/{{ $bahanbaku->ID_BahanBaku }}" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?"><i class="fas fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</section>
@endsection
