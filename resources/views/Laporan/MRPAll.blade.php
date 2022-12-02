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

    @switch($jenis)
    @case('ALLPROD')
    <center>
        <h1>Laporan Produksi</h1>
    </center>
    <div class="invoice">

        <table>
            <tr>
                <td align="left" style="width: 35%;">
                    Date range : {{$start.' - '.$end}} <br>
                </td>
            </tr>
        </table>

    </div>
    @break
    @case('ALLMRP')
    <center>
        <h1>Data MRP</h1>
    </center>
    <div class="invoice">

        <table>
            <tr>
                <td align="left" style="width: 35%;">

                    [ Date range : {{$start.' - '.$end}} ] <br>

                </td>
            </tr>
        </table>

    </div>
    @break
    $@default
    @endswitch



    @foreach($mpsON as $itemMPS)
    @switch($jenis)
    @case('ALLPROD')
    <div class="rincian">
        <table>
            <tr>
                <td align="left" style="width: 35%;">
                    Nama Produk : {{$itemMPS->Produk->Nama_Produk }} <br>
                    Status Produksi : {{$itemMPS->status}} <br>
                    Tanggal Pesan : {{$itemMPS->Tanggal_MPS}} <br>
                    Ukuran Produk : {{$itemMPS->Produk->Ukuran_Produk}} <br>

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
                @foreach ($mrp as $itemMRP)
                @if ($itemMRP->MPS_ID == $itemMPS->ID_MPS)

                @if ($itemMRP->BOM_ID != null)
                @if ( $itemMRP->BOM->Level_BOM != 2 )
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{$itemMRP->Kode_MRP}}</td>
                    <td>{{$itemMRP->BOM->BahanBaku->Nama_BahanBaku?? $itemMRP->BOM->Nama_Part ?? $itemMRP->Produk->Nama_Produk?? '-'}}</td>
                    <td>{{$itemMRP->BOM->Level_BOM?? $itemMRP->Produk->Level_BOM ??'-'}}</td>
                    <td>{{$itemMRP->POREL??'-'}}</td>
                    <td>{{$itemMRP->Tanggal_Pesan}}</td>
                    <td>{{$itemMRP->Tanggal_Selesai}}</td>
                </tr>
                @endif
                @else
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{$itemMRP->Kode_MRP}}</td>
                    <td>{{$itemMRP->BOM->BahanBaku->Nama_BahanBaku?? $itemMRP->BOM->Nama_Part ?? $itemMRP->Produk->Nama_Produk?? '-'}}</td>
                    <td>{{$itemMRP->BOM->Level_BOM?? $itemMRP->Produk->Level_BOM ??'-'}}</td>
                    <td>{{$itemMRP->POREL??'-'}}</td>
                    <td>{{$itemMRP->Tanggal_Pesan}}</td>
                    <td>{{$itemMRP->Tanggal_Selesai}}</td>
                </tr>
                @endif
                @endif

                @endforeach

            </tbody>
        </table>

    </div>
    <hr>
    @break
    @case('ALLMRP')

    <div class="rincian">
        <table>
            <tr>
                <td align="left" style="width: 35%;">
                    Nama Produk : {{$itemMPS->Produk->Nama_Produk }} <br>
                    Status Produksi : {{$itemMPS->status}} <br>
                    Tanggal Pesan : {{$itemMPS->Tanggal_MPS}} <br>
                    Ukuran Produk : {{$itemMPS->Produk->Ukuran_Produk}} <br>

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
                @foreach ($mrp as $itemMRP)
                @if ($itemMRP->MPS_ID == $itemMPS->ID_MPS)
                @if ($itemMRP->BOM_ID != null)

                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{$itemMRP->Kode_MRP}}</td>
                    <td>{{$itemMRP->BOM->BahanBaku->Nama_BahanBaku?? $itemMRP->BOM->Nama_Part ?? $itemMRP->Produk->Nama_Produk?? '-'}}</td>
                    <td>{{$itemMRP->BOM->Level_BOM?? $itemMRP->Produk->Level_BOM ??'-'}}</td>
                    <td>{{$itemMRP->POREL??'-'}}</td>
                    <td>{{$itemMRP->Tanggal_Pesan}}</td>
                    <td>{{$itemMRP->Tanggal_Selesai}}</td>
                </tr>
                @else
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{$itemMRP->Kode_MRP}}</td>
                    <td>{{$itemMRP->BOM->BahanBaku->Nama_BahanBaku?? $itemMRP->BOM->Nama_Part ?? $itemMRP->Produk->Nama_Produk?? '-'}}</td>
                    <td>{{$itemMRP->BOM->Level_BOM?? $itemMRP->Produk->Level_BOM ??'-'}}</td>
                    <td>{{$itemMRP->POREL??'-'}}</td>
                    <td>{{$itemMRP->Tanggal_Pesan}}</td>
                    <td>{{$itemMRP->Tanggal_Selesai}}</td>
                </tr>
                @endif
                @endif

                @endforeach

            </tbody>
        </table>

    </div>
    <hr>
    @break
    @case('ALLBB')

    <div class="rincian">
        <table>
            <tr>
                <td align="left" style="width: 35%;">
                    Nama Produk : {{$itemMPS->Produk->Nama_Produk }} <br>
                    Status Produksi : {{$itemMPS->status}} <br>
                    Tanggal Pesan : {{$itemMPS->Tanggal_MPS}} <br>
                    Ukuran Produk : {{$itemMPS->Produk->Ukuran_Produk}} <br>

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
                @foreach ($mrp as $itemMRP)
                @if ($itemMRP->MPS_ID == $itemMPS->ID_MPS)

                @if ($itemMRP->BOM_ID != null)
                @if ( $itemMRP->BOM->Level_BOM == 2 )
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{$itemMRP->Kode_MRP}}</td>
                    <td>{{$itemMRP->BOM->BahanBaku->Nama_BahanBaku?? $itemMRP->BOM->Nama_Part ?? $itemMRP->Produk->Nama_Produk?? '-'}}</td>
                    <td>{{$itemMRP->BOM->Level_BOM?? $itemMRP->Produk->Level_BOM ??'-'}}</td>
                    <td>{{$itemMRP->POREL??'-'}}</td>
                    <td>{{$itemMRP->Tanggal_Pesan}}</td>
                    <td>{{$itemMRP->Tanggal_Selesai}}</td>
                </tr>
                @endif
                @endif
                @endif

                @endforeach

            </tbody>

        </table>

    </div>
    <hr>
    @break
    $@default
    @endswitch

    @endforeach
</body>
</html>
