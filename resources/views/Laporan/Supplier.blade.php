@extends('Laporan.main')
@section('content')
    <section class="section">
        <img src="C:\xampp\htdocs\CIS_Project\public\assets\img\CIS_logo\android-chrome-192x192.png" alt="Logo CIS">
        <div class="section-header">

            <h1>Cahaya Indah Surgawi</h1>
        </div>
        <div class="section-body">

            <div class="table-responsive p-2 ">
                <table class="display table table-striped table-md" border-line="0,5">
                    <thead>
                        <tr>
                            <th scope="col">ID Supplier</th>
                            <th scope="col">Nama Usaha</th>
                            <th scope="col">Pemilik Usaha</th>
                            <th scope="col">Alamat Usaha</th>
                            <th scope="col">Nomor Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supplier as $supplier)
                            <tr>
                                <td>{{ $supplier->Kode_Supplier }}</td>
                                <td>{{ $supplier->Nama_Supplier }}</td>
                                <td> {{ $supplier->Pemilik_Supplier }} </td>
                                <td> {{ $supplier->Alamat_Supplier }} </td>
                                <td> {{ $supplier->Telp_Supplier }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
@endsection
