@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Kebutuhan Bahan Baku</h1>
    </div>

    <div class="section-body">
        <form action="/Gudang" method="get">
            <div class="input-group mb-3 col-md-4 float-right">
                <input type="text" id="created_at" name="date" class="form-control">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit">Filter</button>
                </div>
                <a target="_blank" class="btn btn-primary ml-2" id="exportpdf">Export PDF</a>
            </div>
        </form>
        <div class="card">
            <div class="table-responsive p-2">
                <table class=" table table-striped table-md">
                    <thead>
                        <tr>
                            <th scope="col">Kode</th>
                            <th scope="col">Nama </th>
                            <th scope="col">Satuan </th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Tanggal Pesan</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col">Status</th>
                            <th scope="col">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mrp as $itemMRP)
                        @if($itemMRP->BOM_ID != null)
                        @if($itemMRP->BOM->Tipe_BOM =="BahanBaku")
                        <tr>
                            <td>{{$itemMRP->Kode_MRP }}</td>
                            <td>{{$itemMRP->BOM ->BahanBaku->Nama_BahanBaku?? '-'}}</td>
                            <td>{{ $itemMRP->BOM->BahanBaku->Satuan_BahanBaku?? '-' }}</td>
                            <td>{{ $itemMRP->GR?? '-' }}</td>
                            <td>{{ $itemMRP->Tanggal_Pesan?? '-' }}</td>
                            <td>{{ $itemMRP->Tanggal_Selesai?? '-' }}</td>
                            <td>{{ $itemMRP->status?? '-' }}</td>
                            <td>
                                <a href="/Gudang/proses/{{$itemMRP->ID_MRP}}" class="btn btn-icon btn-primary"><i class="fa fa-check"></i></a>

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



    <div class="section-body">
    </div>
</section>
@endsection
@push('js-internal')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    //KETIKA PERTAMA KALI DI-LOAD MAKA TANGGAL NYA DI-SET TANGGAL SAA PERTAMA DAN TERAKHIR DARI BULAN SAAT INI
    $(document).ready(function() {
        let start = moment().startOf('month')
        let end = moment().endOf('month')

        //KEMUDIAN TOMBOL EXPORT PDF DI-SET URLNYA BERDASARKAN TGL TERSEBUT
        $('#exportpdf').attr('href', '/Gudang/kebutuhanPDF/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))

        //INISIASI DATERANGEPICKER
        $('#created_at').daterangepicker({
            startDate: start
            , endDate: end
        }, function(first, last) {
            //JIKA USER MENGUBAH VALUE, MANIPULASI LINK DARI EXPORT PDF
            $('#exportpdf').attr('href', '/Gudang/kebutuhanPDF/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
        })
    })

</script>
@endpush
