@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Laporan Produksi</h1>
    </div>

    <div class="section-body">
        <form action="/ProduksiDone" method="get">
            <div class="input-group mb-3">
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
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Ukuran</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">tanggal Pesan</th>
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

                            <td>
                                <a href="/PROD/showPROD/{{$item->ID_MPS}}" class="btn btn-icon  m-2 btn-primary"><i class="far fa-eye"></i></a>
                                {{-- <a href="/PROD/accPROD/{{$item->ID_MPS}}" class="btn btn-icon m-2 btn-success"><i class=" fas fa-check"></i></a> --}}
                            </td>
                        </tr>
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
        $('#exportpdf').attr('href', '/Produksi/exportAllDone/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))

        //INISIASI DATERANGEPICKER
        $('#created_at').daterangepicker({
            startDate: start
            , endDate: end
        }, function(first, last) {
            //JIKA USER MENGUBAH VALUE, MANIPULASI LINK DARI EXPORT PDF
            $('#exportpdf').attr('href', '/Produksi/exportAllDone/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
        })
    })

</script>
@endpush
