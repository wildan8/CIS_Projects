@extends('main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Master Bahan Baku</h1>
        </div>

        <div>
            <a href="#" class="btn btn-icon icon-left btn-primary "><i class="far fa-edit"></i> Tambah Data</a>
        </div>


        <div class="section-body">
            <div class="card">
                <div class="table-responsive p-2">
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

                            <tr>
                                <td>asdasd</td>
                                <td>asdasd</td>
                                <td>asdasd</td>
                                <td>asdasd</td>
                                <td>asdasd</td>

                                <td>
                                    <a href="#" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                                    <a href="#" class="btn btn-icon btn-danger"
                                        onclick="return confirm('Apakah Yakin ingin Menghapus Data?"><i
                                            class="fas fa-times"></i></a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
