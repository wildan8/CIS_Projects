@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Detail Produksi</h1>
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

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mrp as $item)
                        @if ($item->BOM_ID != null)
                        @if($item->BOM->Level_BOM == 1)
                        <tr>
                            <td>
                                @if (strlen($item->Kode_MRP) > 10)
                                {{ substr($item->Kode_MRP, 0, 10) . '...' }}
                                @else
                                {{ $item->Kode_MRP }}
                                @endif
                            </td>

                            <td>{{$item->BOM->BahanBaku->Nama_BahanBaku?? $item->BOM->Nama_Part ?? $item->Produk->Nama_Produk?? '-'}}</td>
                            <td>@if($item->BOM->Level_BOM== 1)
                                Parts
                                @endif
                            </td>
                            <td>{{$item->POREL??'-'}}</td>
                            <td>{{$item->Tanggal_Pesan}}</td>
                            <td>{{$item->Tanggal_Selesai}}</td>

                        </tr>
                        @elseif($item->BOM->Level_BOM == 0)
                        <tr>
                            <td>
                                @if (strlen($item->Kode_MRP) > 10)
                                {{ substr($item->Kode_MRP, 0, 10) . '...' }}
                                @else
                                {{ $item->Kode_MRP }}
                                @endif
                            </td>

                            <td>{{$item->BOM->BahanBaku->Nama_BahanBaku?? $item->BOM->Nama_Part ?? $item->Produk->Nama_Produk?? '-'}}</td>
                            <td>@if($item->BOM->Level_BOM== 0)
                                Assembly
                                @endif
                            </td>
                            <td>{{$item->POREL??'-'}}</td>
                            <td>{{$item->Tanggal_Pesan}}</td>
                            <td>{{$item->Tanggal_Selesai}}</td>
                        </tr>

                        @endif
                        @else
                        <tr>
                            <td>
                                @if (strlen($item->Kode_MRP) > 10)
                                {{ substr($item->Kode_MRP, 0, 10) . '...' }}
                                @else
                                {{ $item->Kode_MRP }}
                                @endif
                            </td>
                            <td>{{$item->BOM->BahanBaku->Nama_BahanBaku?? $item->BOM->Nama_Part ?? $item->Produk->Nama_Produk?? '-'}}</td>
                            <td>Assembly </td>
                            <td>{{$item->POREL??'-'}}</td>
                            <td>{{$item->Tanggal_Pesan}}</td>
                            <td>{{$item->Tanggal_Selesai}}</td>

                        </tr>
                        @endif
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
                            <th scope="col">Nama</th>
                            <th scope="col">Level MRP</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Tanggal Pesan</th>
                            <th scope="col">Tanggal Selesai</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mrp as $item)
                        @if ($item->BOM_ID != null)
                        @if($item->BOM->Level_BOM == 2)
                        <tr>
                            <td>
                                @if (strlen($item->Kode_MRP) > 10)
                                {{ substr($item->Kode_MRP, 0, 10) . '...' }}
                                @else
                                {{ $item->Kode_MRP }}
                                @endif
                            </td>

                            <td>{{$item->BOM->BahanBaku->Nama_BahanBaku?? $item->BOM->Nama_Part ?? $item->Produk->Nama_Produk?? '-'}}</td>
                            <td>@if($item->BOM->Level_BOM== 2)
                                Bahan Baku
                                @endif
                            </td>
                            <td>{{$item->POREL??'-'}}</td>
                            <td>{{$item->Tanggal_Pesan}}</td>
                            <td>{{$item->Tanggal_Selesai}}</td>

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
