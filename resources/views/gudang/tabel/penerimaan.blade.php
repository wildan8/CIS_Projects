@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Log Data Penerimaan Bahan Baku</h1>
    </div>
    @if (session()->has('statusLOG'))
    <div class="alert alert-success">
        {{ session('statusLOG') }}
    </div>
    @endif
    @if (session()->has('hapusLOG'))
    <div class="alert alert-danger">
        {{ session('hapusLOG') }}
    </div>
    @endif
    @if (session()->has('statusLOGKosong'))
    <div class="alert alert-danger">
        {{ session('statusLOGKosong') }}
    </div>
    @endif
    <div>

        {{-- <a href="/log/export" class="btn btn-icon icon-left btn-danger m-2"><i class="far fa-edit"></i> Export
            Data</a> --}}
    </div>
    <div>
    </div>

    <form action="/LOG" method="get">
        <div class="input-group mb-3 col-md-4 float-right">
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
                <table class="table table-striped table-md">
                    <thead>
                        <th scope="col">ID</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">tanggal</th>
                        <th scope="col">status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penerimaan as $LOG)
                        <tr>
                            <td>{{ $LOG->Kode_LOG }}</td>
                            <td>{{ $LOG->BahanBaku->Nama_BahanBaku }}</td>
                            <td>{{ $LOG->Jumlah_LOG }}</td>
                            <td>{{ $LOG->Tanggal_LOG }}</td>
                            <td>
                                @if ($LOG->Status_LOG == 'Issuing')
                                <div class="badge badge-warning">{{ $LOG->Status_LOG }}</div>
                                @else
                                <div class="badge badge-info">{{ $LOG->Status_LOG }}</div>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$penerimaan -> links()}}
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
        $('#exportpdf').attr('href', '/LOG/export/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))

        //INISIASI DATERANGEPICKER
        $('#created_at').daterangepicker({
            startDate: start
            , endDate: end
        }, function(first, last) {
            //JIKA USER MENGUBAH VALUE, MANIPULASI LINK DARI EXPORT PDF
            $('#exportpdf').attr('href', '/LOG/export/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
        })
    })

</script>
@endpush
