@extends('main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Master BOM</h1>
        </div>
        <div>
            <a href="/BOM/createBOM" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Data</a>
        </div>



        <div class="section-body">
            <div class="card">
                <div class="table-responsive p-2">
                    <table class="table table-striped table-md">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nama</th>
                                <th scope="col">aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Produk as $BOM)
                                <tr>
                                    <td>{{ $BOM->ID_Produk }}</td>
                                    <td>{{ $BOM->Nama_Produk }}</td>
                                    <td>
                                        <a href="/BOM/showBOM/{{ $BOM->ID_Produk }}" class="btn btn-icon btn-primary"><i
                                                class="far fa-edit"></i></a>
                                        <a href="/BOM/deleteBOM/{{ $BOM->ID_BOM }}" class="btn btn-icon btn-danger"
                                            onclick="return confirm('yakin?')"><i class="fas fa-times"></i></a>
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
