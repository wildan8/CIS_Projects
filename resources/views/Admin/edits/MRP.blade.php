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
                            <th scope="col">Kode MRP</th>

                            <th scope="col">Nama</th>
                            <th scope="col">Level MRP</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Tanggal Pesan</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col">status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mrp as $item)
                        <tr>
                            <td>
                                @if (strlen($item->Kode_MRP) > 10)
                                {{ substr($item->Kode_MRP, 0, 10) . '...' }}
                                @else
                                {{ $item->Kode_MRP }}
                                @endif
                            </td>

                            <td>{{$item->BOM->BahanBaku->Nama_BahanBaku?? $item->BOM->Nama_Part ?? $item->Produk->Nama_Produk?? '-'}}</td>
                            <div hidden>{{$lvl = $item->BOM->Level_BOM?? $item->Produk->Level_BOM ??'-'}}</div>
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
                            <td>{{$item->Tanggal_Pesan}}</td>
                            <td>{{$item->Tanggal_Selesai}}</td>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="section-body">
    </div>
</section>
@endsection
