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
    <div class="rincian">
        <table>
            <tr>
                <td align="left" style="width: 35%;">
                    Nama Produk :{{$Produk->Nama_Produk }} <br>
                    Ukuran Produk : {{$Produk->Ukuran_Produk}} <br>
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
                    <th scope="col">Tipe Bagian</th>
                    <th scope="col">Nama Parts</th>
                    <th scope="col">Jumlah</th>
                </tr>
            </thead>
            <tbody align="center">
                @php
                $no =1;
                @endphp
                @foreach ($dataParts as$data)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{$data->Kode_BOM }}</td>
                    <td>{{$data->Tipe_BOM }}</td>
                    <td>{{$data->Nama_Part?? '-' }}</td>
                    <td> {{$data->Jumlah_BOM }} </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table width="95%" border="1">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kode Bahan Baku</th>
                    <th scope="col">Tipe Bagian</th>
                    <th scope="col">Nama Bahan Baku</th>
                    <th scope="col">Jumlah</th>
                </tr>
            </thead>
            <tbody align="center">
                @php
                $no =1;
                @endphp
                @foreach ($dataBB as$data)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{$data->Kode_BOM }}</td>
                    <td>{{$data->Tipe_BOM }}</td>
                    <td>{{$data->BahanBaku->Nama_BahanBaku?? '-' }}</td>
                    <td> {{$data->Jumlah_BOM }} </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
