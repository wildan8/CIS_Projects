@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Payment Process</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="table-responsive p-2">
                <table class=" table table-striped table-md">
                    <thead>
                        <tr>
                            <th scope="col">Kode</th>
                            <th scope="col">Nama </th>
                            <th scope="col">Satuan </th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga</th>
                            <th scope="col">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mrp as $itemMRP)

                        @if($itemMRP->BOM_ID != null)
                        @if($itemMRP->Level_BOM =="2")

                        <tr>
                            <td>{{ $itemMRP->Kode_MRP }}</td>
                            <td>{{$itemMRP->Nama_BahanBaku}}</td>
                            <td>{{ $itemMRP->Satuan_BahanBaku }}</td>
                            <td>{{ $itemMRP->sum_POREL }}</td>
                            <td>{{ "Rp.".  $itemMRP->Harga_Satuan * $itemMRP->sum_POREL }}</td>
                            <td>
                                <a href="/Payment/createPAY/{{$itemMRP->ID_MRP}}" class="btn btn-icon btn-primary"><i class="fa fa-check"></i></a>

                            </td>
                        </tr>
                        @endif

                        @endif

                        @endforeach

                    </tbody>

                </table>
                {{$mrp -> links()}}
            </div>
        </div>

    </div>

</section>
@endsection
