@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Hitung MRP</h1>
    </div>

    <div class="section-body">

        <div class="card">
            <div class="table-responsive p-2">
                <table class=" table table-striped table-md" name="table">
                    @error('table')
                    <div class="invalid-feedback">
                        Isi Dengan Nama Produk.
                    </div>
                    @enderror
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
                        @foreach ($mpsW as $mps)
                        <tr>
                            <td>{{ $mps->Kode_MPS }}</td>
                            <td>{{ $mps->Produk->Nama_Produk ?? '-' }}</td>
                            <td>{{ $mps->Ukuran_Produk }}</td>
                            <td>{{ $mps->Jumlah_MPS }}</td>
                            <td>{{ $mps->Tanggal_MPS }}</td>
                            <td>{{$mps -> status}}</td>
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
                        @foreach ($mpsON as $item)
                        <tr>

                            <td>{{ $item->Kode_MPS }}</td>
                            <td>{{ $item->Produk->Nama_Produk ?? '-' }}</td>
                            <td>{{ $item->Produk->Ukuran_Produk }}</td>
                            <td>{{ $item->Jumlah_MPS }}</td>
                            <td>{{ $item->Tanggal_MPS }}</td>
                            <td>{{$item -> status}}</td>
                            <td>
                                <a href="/MRP/showMRP/{{$item->ID_MPS}}" class="btn btn-icon  m-2 btn-primary"><i class="far fa-eye"></i></a>
                                <a href="/MRP/deleteMRP/{{$item->ID_MPS}}" class="btn btn-icon  m-2 btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i class="fas fa-times"></i></a>
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
