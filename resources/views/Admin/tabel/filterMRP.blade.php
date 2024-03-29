@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard <i>Material Requrement Planning</i> (MRP)</h1>
    </div>

    <div class="section-body">


        {{-- <div>
            <a href="/MRP/exportAll" class="btn btn-icon icon-left  btn-danger m-2"><i class="far fa-edit"></i> Export
                Data</a>
        </div> --}}
        <form action="/Admin" method="get">
            <div class="input-group mb-3 col-md-4 ml-auto">
                <input type="text" id="created_at" name="date" class="form-control">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit">Filter</button>
                </div>
                <a target="_blank" class="btn btn-primary ml-2" id="exportpdf">Export PDF</a>
            </div>
        </form>
        {{-- <a href="/MRP/ExportMRP" class="btn btn-icon  m-2 btn-primary"><i class="far fa-eye"></i></a> --}}
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
                            <th scope="col">tanggal Dibutuhkan</th>
                            <th scope="col">Status</th>
                            <th scope="col">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mpsON as $item)
                        <tr>

                            <td>{{ $item->Kode_MPS }}</td>
                            <td>{{ $item->Nama_Produk ?? '-' }}</td>
                            <td>{{ $item->Ukuran_Produk }}</td>
                            <td>{{ $item->Jumlah_MPS }}</td>
                            <td>{{ $item->Tanggal_MPS }}</td>
                            <td>{{ $item->Tanggal_Selesai }}</td>

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
                            <td>
                                <a href="/MRP/showMRP/{{$item->ID_MPS}}" class="btn btn-icon  m-2 btn-primary"><i class="far fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$mpsON -> links()}}
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
        $('#exportpdf').attr('href', '/MRP/exportAll/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))
        $('#ExcelMRP').attr('href', '/MRP/ExcelMRP/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))

        //INISIASI DATERANGEPICKER
        $('#created_at').daterangepicker({
            startDate: start
            , endDate: end
        }, function(first, last) {
            //JIKA USER MENGUBAH VALUE, MANIPULASI LINK DARI EXPORT PDF
            $('#exportpdf').attr('href', '/MRP/exportAll/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
            $('#ExcelMRP').attr('href', '/MRP/ExcelMRP/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))
        })
    })

</script>
@endpush
