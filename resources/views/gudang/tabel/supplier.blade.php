@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Master Supplier</h1>
    </div>
    @if (session()->has('statusSupplier'))
    <div class="alert alert-success">
        {{ session('statusSupplier') }}
    </div>
    @endif

    @if (session()->has('hapusSupplier'))
    <div class="alert alert-danger">
        {{ session('hapusSupplier') }}
    </div>
    @endif
    @if (session()->has('updateSupplier'))
    <div class="alert alert-success">
        {{ session('updateSupplier') }}
    </div>
    @endif
    <div>
        <a href="/Supplier/createSUP" class="btn btn-icon icon-left btn-primary m-2"><i class="far fa-edit"></i> Tambah
            Data</a>
        <a href="/Supplier/exportSUP" class="btn btn-icon icon-left btn-danger m-2"> Export
            Data</a>

    </div>
    <div class="section-body">
        <div class="card">
            <div class="table-responsive p-2">
                <table class="table table-striped table-md">
                    <thead>
                        <tr>
                            <th scope="col">ID Supplier</th>
                            <th scope="col">Nama Usaha</th>
                            <th scope="col">Pemilik Usaha</th>

                            <th scope="col">Alamat Usaha</th>
                            <th scope="col">Nomor Telepon</th>
                            <th scope="col">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supplier as $s)
                        <tr>
                            <td>{{ $s->Kode_Supplier }}</td>
                            <td>
                                @if (strlen($s->Nama_Supplier) > 20)
                                {{ substr($s->Nama_Supplier, 0, 20) . '...' }}
                                @else
                                {{ $s->Nama_Supplier }}
                                @endif
                            <td>
                                @if (strlen($s->Pemilik_Supplier) > 10)
                                {{ substr($s->Pemilik_Supplier, 0, 10) . '...' }}
                                @else
                                {{ $s->Pemilik_Supplier }}
                                @endif
                            </td>
                            <td>
                                @if (strlen($s->Alamat_Supplier) >= 15)
                                {{ substr($s->Alamat_Supplier, 0, 15) . '...' }}
                                @else
                                {{ $s->Alamat_Supplier }}
                                @endif
                            <td>{{ $s->Telp_Supplier }}</td>
                            <td>
                                <a href="/Supplier/editSUP/{{ $s->ID_Supplier }}" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>

                                <a href="/Supplier/deleteSUP/{{ $s->ID_Supplier }}" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$supplier -> links()}}
            </div>
        </div>
    </div>
</section>
@endsection
