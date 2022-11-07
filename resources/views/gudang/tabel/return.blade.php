@extends('main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Master Return Bahan Baku</h1>
        </div>
        @if (session()->has('statusReturn'))
            <div class="alert alert-success">
                {{ session('statusReturn') }}
            </div>
        @endif
        @if (session()->has('hapusReturn'))
            <div class="alert alert-success">
                {{ session('hapusReturn') }}
            </div>
        @endif
        @if (session()->has('updateReturn'))
            <div class="alert alert-success">
                {{ session('updateReturn') }}
            </div>
        @endif
        <div>
            <a href="/Return/createRET" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Data</a>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">tanggal</th>
                    <th scope="col">Status</th>
                    <th scope="col">aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($return as $return)
                    <tr>
                        <td>{{ $return->ID_ReturnProduk }}</td>
                        <td>Nama Bahan Baku (Foreign Key)</td>
                        <td>{{ $return->Jumlah_ReturnProduk }}</td>
                        <td>{{ $return->Tanggal_ReturnProduk }}</td>
                        <td>{{ $return->Status_ReturnProduk }}</td>
                        <td>
                            <a href="/ReturnProduk/editSUP/{{ $return->ID_ReturnProduk }}"
                                class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                            <a href="/ReturnProduk/deleteSUP/{{ $return->ID_ReturnProduk }}" class="btn btn-icon btn-danger"
                                onclick="return confirm('Apakah Yakin ingin Menghapus Data?"><i
                                    class="fas fa-times"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="section-body">
        </div>
    </section>
@endsection
