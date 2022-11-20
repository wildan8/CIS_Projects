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
                            <th scope="col">Kode MRP</th>
                            <th scope="col">Kode Pesan</th>
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
                        @foreach ($mrp as $item)
                        <tr>
                            <td>
                                @if (strlen($item->Kode_MRP) > 12)
                                {{ substr($item->Kode_MRP, 0, 12) . '...' }}
                                @else
                                {{ $item->Kode_MRP }}
                                @endif
                            </td>
                            <td>
                                @if (strlen($item->MPS->Kode_MPS) > 10)
                                {{ substr($item->MPS->Kode_MPS, 0, 10) . '...' }}
                                @else
                                {{ $item->MPS->Kode_MPS }}
                                @endif
                            </td>
                            <td>{{$item->BOM->BahanBaku->Nama_BahanBaku?? $item->BOM->Nama_Part ?? $item->Produk->Nama_Produk?? '-'}}</td>
                            <td>{{$item->BOM->Level_BOM?? $item->Produk->Level_BOM ??'-'}}</td>
                            <td>{{$item->POREL??'-'}}</td>
                            <td>{{$item->Tanggal_Pesan}}</td>
                            <td>{{$item->Tanggal_Selesai}}</td>
                            <td>{{$item->MPS ->status}}</td>

                            <td>
                                <a href="/MRP/editMRP/#" class="btn btn-icon  m-2 btn-primary"><i class="far fa-eye"></i></a>
                                <a href="/MRP/deleteMRP/#" class="btn btn-icon  m-2 btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i class="fas fa-times"></i></a>
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
