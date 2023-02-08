@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Detail MRP</h1>
    </div>
    @if (session()->has('statusMRP'))
    <div class="alert alert-success">
        {{ session('statusMRP') }}
    </div>
    @endif
    @if (session()->has('nullMRP'))
    <div class="alert alert-danger">
        {{ session('nullMRP') }}
    </div>
    @endif
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
            <a href="/MRP/export/{{ $mps->ID_MPS }}" class="btn btn-danger m-2"><i class="far fa-edit"></i> Export
                Data</a>
        </div>
        <div class="card">
            <div class="table-responsive p-2">
                <table class=" table table-striped table-md">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Level BOM</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Tanggal Dipesan</th>
                            <th scope="col">Tanggal Dibutuhkan</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mrp_BB as $item)
                        <tr>
                            {{-- <td>{{$item->BOM_ID}}</td> --}}
                            <td>{{$item->Nama_BahanBaku?? $item->Nama_Part ?? $item->Nama_Produk?? '-'}}</td>
                            <div hidden>{{$lvl = $item->Level_BOM?? $item->Level_BOM ??'-'}}</div>
                            <td>
                                @if($lvl == 2)
                                Bahan Baku
                                @elseif($lvl == 1)
                                Part
                                @elseif($lvl == 0)
                                Produk
                                @endif
                            </td>
                            <td>{{$item->sum_POREL??'-'}}</td>
                            <td>{{$item->satuan_BahanBaku?? '-'}}</td>
                            <td>{{$item->Tanggal_Pesan?? '-'}}</td>
                            <td>{{$item->Tanggal_Selesai?? '-'}}</td>
                            <td>
                                @if ($item ->status == 'Payment-Success')
                                <div class="badge badge-primary">{{ $item ->status }}</div>
                                @elseif($item ->status == 'On-Progress')
                                <div class="badge badge-info">{{ $item ->status }}</div>
                                @elseif($item ->status == 'Production')
                                <div class="badge badge-warning">{{ $item ->status }}</div>
                                @elseif($item ->status == 'Done')
                                <div class="badge badge-success">{{ $item ->status }}</div>
                                @endif
                            </td>

                        </tr>
                        @endforeach

                        @foreach ($mrp_etc as $item)
                        <div hidden>{{$lvl = $item->BOM->Level_BOM?? $item->Produk->Level_BOM ??'-'}}</div>
                        @if ($lvl == 1 OR $lvl == 0)
                        <tr>

                            <td>{{$item->BOM->BahanBaku->Nama_BahanBaku?? $item->BOM->Nama_Part ?? $item->Produk->Nama_Produk?? '-'}}</td>

                            <td>
                                @if($lvl == 2)
                                Bahan Baku
                                @elseif($lvl == 1)
                                Part
                                @elseif($lvl == 0)
                                Produk
                                @endif
                            </td>
                            <td>{{$item->POREL??'-'}}</td>
                            <td>
                                @if($lvl == 1)
                                Pcs
                                @elseif($lvl == 0)
                                Pcs
                                @endif
                            </td>
                            <td>{{$item->Tanggal_Pesan}}</td>
                            <td>{{$item->Tanggal_Selesai?? '-'}}</td>
                            <td>
                                @if ($item ->status == 'Payment-Success')
                                <div class="badge badge-primary">{{ $item ->status }}</div>
                                @elseif($item ->status == 'On-Progress')
                                <div class="badge badge-info">{{ $item ->status }}</div>
                                @elseif($item ->status == 'Production')
                                <div class="badge badge-warning">{{ $item ->status }}</div>
                                @elseif($item ->status == 'Done')
                                <div class="badge badge-success">{{ $item ->status }}</div>
                                @endif
                            </td>

                        </tr>
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
