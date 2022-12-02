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
    <div class="rincian">
        <table>
            <tr>
                <td align="left" style="width: 35%;">
                    Nama Produk :{{$mps->Produk->Nama_Produk }} <br>
                    Status Produksi : {{$mps->status}} <br>
                    Tanggal Pesan : {{$mps->Tanggal_MPS}} <br>
                    Tanggal Selesai : {{$mrpTanggal->Tanggal_Selesai}} <br>
                    Ukuran Produk : {{$mps->Produk->Ukuran_Produk}} <br>
                    Jumlah Data : {{$Jumlah}} <br>
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
                    <th scope="col">Level</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">tanggal Pesan</th>
                    <th scope="col">tanggal Selesai</th>

                </tr>
            </thead>
            <tbody align="center">
                @php
                $no =1;
                @endphp
                @foreach ($mrp as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{$item->Kode_MRP}}</td>

                    <td>{{$item->BOM->BahanBaku->Nama_BahanBaku?? $item->BOM->Nama_Part ?? $item->Produk->Nama_Produk?? '-'}}</td>
                    <td>{{$item->BOM->Level_BOM?? $item->Produk->Level_BOM ??'-'}}</td>
                    <td>{{$item->POREL??'-'}}</td>
                    <td>{{$item->Tanggal_Pesan}}</td>
                    <td>{{$item->Tanggal_Selesai}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>
</html>
