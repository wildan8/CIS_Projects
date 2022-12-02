@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Detail Pesanan</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="form-group col-12">
                <label>Kode MPS</label>
                <input type="text" class="form-control" name="Nama_Produk" value="{{ $mps->Kode_MPS }}" disabled>

            </div>
            <div class="form-group col-12">
                <label>Nama Produk</label>
                <input type="text" class="form-control" name="Ukuran_Tampil" value="{{ $mps->Produk->Nama_Produk }}" disabled>
            </div>
            <div class="form-group col-12">
                <label>Tanggal Pesan</label>
                <input type="text" class="form-control" name="Ukuran_Tampil" value="{{ $mps->Tanggal_MPS }}" disabled>
            </div>
        </div>
        <div>
            <a href="/Gudang/export/{{ $mps->ID_MPS }}" class="btn btn-danger m-2"><i class="far fa-edit"></i> Export
                Data</a>
        </div>
        <div class="card">
            <div class="table-responsive p-2">
                <table class=" table table-striped table-md">
                    <thead>
                        <tr>
                            <th scope="col">Kode MRP</th>

                            <th scope="col">Nama</th>
                            <th scope="col">Level MRP</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Tanggal Pesan</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col">status</th>
                        </tr>
                    </thead>
                    <tbody align="center">

                        @foreach ($mrp as $itemMRP)


                        @if ($itemMRP->BOM_ID != null)
                        @if ( $itemMRP->BOM->Level_BOM == 2 )
                        <tr>

                            <td>{{$itemMRP->Kode_MRP}}</td>
                            <td>{{$itemMRP->BOM->BahanBaku->Nama_BahanBaku?? $itemMRP->BOM->Nama_Part ?? $itemMRP->Produk->Nama_Produk?? '-'}}</td>
                            <td>{{$itemMRP->BOM->Level_BOM?? $itemMRP->Produk->Level_BOM ??'-'}}</td>
                            <td>{{$itemMRP->POREL??'-'}}</td>
                            <td>{{$itemMRP->Tanggal_Pesan}}</td>
                            <td>{{$itemMRP->Tanggal_Selesai}}</td>
                            <td>{{$itemMRP->status}}</td>
                        </tr>
                        @endif

                        @endif


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
