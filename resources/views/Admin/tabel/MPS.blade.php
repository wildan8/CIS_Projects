@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Master MPS</h1>
    </div>

    @if (session()->has('statusMPS'))
    <div class="alert alert-success">
        {{session('statusMPS')}}
    </div>
    @endif
    @if (session()->has('hapusMPS'))
    <div class="alert alert-success">
        {{session('hapusMPS')}}
    </div>
    @endif
    @if (session()->has('updateMPS'))
    <div class="alert alert-success">
        {{session('updateMPS')}}
    </div>
    @endif
    <div>
        <a href="/MPS/createMPS" class="btn btn-icon icon-left  btn-primary m-2"><i class="far fa-edit"></i> Tambah
            Data</a>
        <a href="/MPS/export" class="btn btn-icon icon-left  btn-danger m-2"><i class="far fa-edit"></i> Export
            Data</a>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="table-responsive p-2">
                <table class=" table table-striped table-md">
                    <thead>
                        <tr>
                            <th scope="col">Kode</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Ukuran</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">tanggal Pesan</th>
                            <th scope="col">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mps as $mps)
                        <tr>
                            <td>{{ $mps->Kode_MPS }}</td>
                            <td>{{ $mps->Produk->Nama_Produk ?? '-' }}</td>
                            <td>{{ $mps->Ukuran_Produk }}</td>
                            <td>{{ $mps->Jumlah_MPS }}</td>
                            <td>{{ $mps->Tanggal_MPS }}</td>
                            <td>
                                <a href="/MPS/editMPS/{{$mps->Kode_MPS}}" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                                <a href="/MPS/deleteMPS/{{$mps->Kode_MPS}}" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i class="fas fa-times"></i></a>
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
