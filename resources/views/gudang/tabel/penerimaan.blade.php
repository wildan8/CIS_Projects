@extends('main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Log Data Penerimaan Bahan Baku</h1>
        </div>
        @if (session()->has('statusLOG'))
            <div class="alert alert-success">
                {{ session('statusLOG') }}
            </div>
        @endif
        @if (session()->has('hapusLOG'))
            <div class="alert alert-danger">
                {{ session('hapusLOG') }}
            </div>
        @endif
        @if (session()->has('statusLOGKosong'))
            <div class="alert alert-danger">
                {{ session('statusLOGKosong') }}
            </div>
        @endif
        <div>
            <a href="/LOG/createLOG" class="btn btn-icon icon-left btn-primary m-2"><i class="far fa-edit"></i> Tambah Data</a>
        </div>



        <div class="section-body">
            <div class="card">
                <div class="table-responsive p-2">
                    <table class="table table-striped table-md">
                        <thead>
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">tanggal</th>
                            <th scope="col">status</th>
                            <th scope="col">aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penerimaan as $LOG)
                                <tr>
                                    <td>{{ $LOG->Kode_LOG }}</td>
                                    <td>{{ $LOG->BahanBaku->Nama_BahanBaku }}</td>
                                    <td>{{ $LOG->Jumlah_LOG }}</td>
                                    <td>{{ $LOG->Tanggal_LOG }}</td>
                                    <td>{{ $LOG->Status_LOG }}</td>
                                    <td>
                                        <a href="/LOG/deleteLOG/{{ $LOG->ID_LOG }}" class="btn btn-icon btn-danger"
                                            onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i
                                                class="fas fa-times"></i></a>
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
