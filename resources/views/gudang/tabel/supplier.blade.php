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
        <a href="/Supplier/export" class="btn btn-icon icon-left btn-danger m-2"><i class="far fa-edit"></i> Export
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
                        @foreach ($supplier as $supplier)
                        <tr>
                            <td>{{ $supplier->Kode_Supplier }}</td>
                            <td>
                                @if (strlen($supplier->Nama_Supplier) > 20)
                                {{ substr($supplier->Nama_Supplier, 0, 20) . '...' }}
                                @else
                                {{ $supplier->Nama_Supplier }}
                                @endif
                            <td>
                                @if (strlen($supplier->Pemilik_Supplier) > 10)
                                {{ substr($supplier->Pemilik_Supplier, 0, 10) . '...' }}
                                @else
                                {{ $supplier->Pemilik_Supplier }}
                                @endif
                            </td>
                            <td>
                                @if (strlen($supplier->Alamat_Supplier) >= 15)
                                {{ substr($supplier->Alamat_Supplier, 0, 15) . '...' }}
                                @else
                                {{ $supplier->Alamat_Supplier }}
                                @endif
                            <td>{{ $supplier->Telp_Supplier }}</td>
                            <td>
                                <a href="/Supplier/editSUP/{{ $supplier->ID_Supplier }}" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>

                                <a href="/Supplier/deleteSUP/{{ $supplier->ID_Supplier }}" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
