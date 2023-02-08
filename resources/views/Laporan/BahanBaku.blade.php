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

    </style>

</head>
<body>

    <div class="information">
        <table width="100%">
            <tr>
                <td align="left" style="width: 35%;">

                </td>
                <td align="center">
                    <img src="logo_CIS-removebg-preview.png" alt="Logo" width="64" class="logo" />
                </td>
                <td align="right" style="width: 35%;">
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

    @if ($jenis == 'KEBUTUHAN')
    <center>
        <h1>Data Kebutuhan Bahan Baku</h1>
    </center>
    <div class="invoice">
        <div class="rincian">
            <table>
                <tr>
                    <td align="left" style="width: 35%;">
                        Judul : {{$Judul}} <br>
                        Tanggal Pembuatan : {{$Tanggal}} <br>
                        Date range : {{$start.' Sampai '.$end}} <br>

                    </td>
                </tr>
            </table>
        </div>
        <div class="invoice">

            <table width="95%" border="1">
                <thead>
                    <tr>
                        <th scope="col">Kode</th>
                        <th scope="col">Nama </th>
                        <th scope="col">Satuan </th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Tanggal Pesan</th>
                        <th scope="col">Tanggal Selesai</th>
                        <th scope="col">Status</th>

                    </tr>
                </thead>
                <tbody align="center">
                    @php
                    $no =1;
                    @endphp
                    @foreach ($mrp as $itemMRP)
                    @if($itemMRP->BOM_ID != null)
                    @if($itemMRP->Level_BOM == 2)
                    @if($itemMRP -> status =='Payment-Success')
                    <tr>
                        <td>{{$itemMRP->Kode_MRP }}</td>
                        <td>{{$itemMRP->Nama_BahanBaku}}</td>
                        <td>{{ $itemMRP->Satuan_BahanBaku }}</td>
                        <td>{{ $itemMRP->sum_POREL }}</td>
                        <td>{{ $itemMRP->Tanggal_Pesan }}</td>
                        <td>{{ $itemMRP->Tanggal_Selesai }}</td>
                        <td>{{ $itemMRP->status }}</td>

                    </tr>
                    @endif
                    @endif
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <center>
            <h1>Data Bahan Baku</h1>
        </center>
        <div class="rincian" style="p-2">
            <table>
                <tr>
                    <td align="left" style="width: 35%;">
                        Judul : {{$Judul}} <br>
                        Tanggal Pembuatan : {{$Tanggal}} <br>
                        Jumlah Data : {{$Jumlah}}
                    </td>
                </tr>
            </table>
        </div>
        <div class="invoice">

            <table width="95%" border="1">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode Bahan Baku</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Nama Supplier</th>

                    </tr>
                </thead>
                <tbody align="center">
                    @php
                    $no =1;
                    @endphp
                    @foreach ($data as$data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{$data->Kode_BahanBaku }}</td>
                        <td>{{$data->Nama_BahanBaku }}</td>
                        <td> {{$data->Stok_BahanBaku }} </td>
                        <td> {{$data->Supplier->Nama_Supplier }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif






</body>
</html>
