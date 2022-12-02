<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Export-{{$Judul}}</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .invoice table {
            margin: 15px;
        }

        .invoice h3 {
            margin-left: 15px;
        }

        .information {
            background-color: #60A7A6;
            color: #FFF;
        }

        .information .logo {
            margin: 5px;
        }

        .information table {
            padding: 10px;
        }

        .rincian table {
            padding: 15px;
        }

    </style>

</head>
<body>

    <div class="information">
        <table width="100%">
            <tr>
                <td align="left" style="width: 35%;">

                    <pre>

<bold>Judul Dokumen        :</bold> {{$Judul }}
<bold>Tanggal Pembuatan :</bold> {{$Tanggal}}

                    </pre>
                </td>
                <td align="center">
                    <img src="logo_CIS-removebg-preview.png" alt="Logo" width="64" class="logo" />
                </td>
                <td align="right" style="width: 35%;margin:100px">
                    <h3>PT. Cahaya Indah Surgawi</h3>
                    <pre>
                    Jl. Raya Kerobokan No.52,
                    Kerobokan Kelod,
                    Kec. Kuta Utara,
                    Kabupaten Badung,
                    Bali 80361.
                    </pre>
                </td>
            </tr>

        </table>
    </div>
    <center>
        <h1>Laporan Payment</h1>
    </center>
    <div class="invoice">
        <div class="rincian">
            <table>
                <tr>
                    <td align="left" style="width: 35%;">

                        Date range : {{$start.' - '.$end}} <br>

                    </td>
                </tr>
            </table>
        </div>


        <div class="invoice">

            <table width="95%" border="1">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode </th>
                        <th scope="col">Nama</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Total</th>
                        <th scope="col">Tanggal Payment</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @php
                    $no =1;
                    @endphp
                    @foreach ($payment as $itemPayment)
                    @if($itemPayment->MRP->BOM_ID != null)
                    @if($itemPayment->MRP->BOM->Tipe_BOM =="BahanBaku")
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$itemPayment->Kode_Payment }}</td>
                        <td>{{$itemPayment->MRP->BOM ->BahanBaku->Nama_BahanBaku}}</td>
                        <td>{{ $itemPayment->MRP->BOM->BahanBaku->Satuan_BahanBaku }}</td>
                        <td>{{ $itemPayment->MRP->GR }}</td>
                        <td>{{ "Rp.".  $itemPayment->MRP->BOM->BahanBaku->Harga_Satuan * $itemPayment->MRP->GR }}</td>
                        <td>{{ $itemPayment->Tanggal_Payment }}</td>
                    </tr>
                    @endif

                    @endif

                    @endforeach

                </tbody>
            </table>

        </div>
        <hr>

</body>
</html>
