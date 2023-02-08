@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard Payment</h1>
    </div>
    <form action="/Payment" method="get">
        <div class="input-group mb-3 col-md-5 ml-auto ">
            <input type="text" id="created_at" name="date" class="form-control">
            <div class="input-group-append">
                <button class="btn btn-secondary" type="submit">Filter</button>
            </div>
            <a target="_blank" class="btn btn-primary ml-2" id="exportpdf">Export PDF</a>
        </div>
    </form>
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
                        @foreach ($payment as $itemPayment)
                        @if($itemPayment->MRP->BOM_ID != null)
                        @if($itemPayment->MRP->BOM->Tipe_BOM =="BahanBaku")
                        <tr>
                            <td>{{$itemPayment->Kode_Payment }}</td>
                            <td>{{$itemPayment->MRP->BOM ->BahanBaku->Nama_BahanBaku}}</td>
                            <td>{{ $itemPayment->MRP->BOM->BahanBaku->Satuan_BahanBaku }}</td>
                            <td>{{ $itemPayment->MRP->GR }}</td>
                            <td>{{ "Rp.".  $itemPayment->MRP->BOM->BahanBaku->Harga_Satuan * $itemPayment->MRP->GR }}</td>
                            <td>
                                <a href="/Payment/deletePAY/{{$itemPayment->ID_Payment}}" class="btn btn-icon btn-danger"><i class="fa fa-times"></i></a>

                            </td>
                        </tr>
                        @endif

                        @endif
                        @endforeach

                    </tbody>

                </table>
                {{$payment -> links()}}
            </div>
        </div>
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
        $('#exportpdf').attr('href', '/Payment/exportPDF/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))

        //INISIASI DATERANGEPICKER
        $('#created_at').daterangepicker({
            startDate: start
            , endDate: end
        }, function(first, last) {
            //JIKA USER MENGUBAH VALUE, MANIPULASI LINK DARI EXPORT PDF
            $('#exportpdf').attr('href', '/Payment/exportPDF/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
        })
    })

</script>
@endpush
