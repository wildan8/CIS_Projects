@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard MRP</h1>
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
                            <th scope="col">Status</th>
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
                            <td>Waiting</td>
                            <td>
                                <a href='/MRP/storeMRP/{{$mps->ID_MPS}}' class="btn btn-icon btn-primary"><i class="fa fa-cog"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive p-2">
                <table class=" table table-striped table-md">
                    <thead>
                        <tr>
                            <th scope="col">Kode MRP</th>
                            <th scope="col">Kode Pesanan</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Level MRP</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Tanggal Pesan</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col">status</th>
                            <th scope="col">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td>MRP-BLA</td>
                        <td>MPS-BLA</td>
                        <td>Kain BBB</td>
                        <td>2</td>
                        <td>7</td>
                        <td>12-12-12</td>
                        <td>14-04-27</td>
                        <td>Success</td>
                        <td>
                            <a href="/MRP/editMRP/#" class="btn btn-icon  m-2 btn-primary"><i class="far fa-eye"></i></a>
                            <a href="/MRP/deleteMRP/#" class="btn btn-icon  m-2 btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i class="fas fa-times"></i></a>
                        </td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="section-body">
    </div>
</section>
@endsection
