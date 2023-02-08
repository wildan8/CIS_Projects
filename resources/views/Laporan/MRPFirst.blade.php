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
                </td>
            </tr>
        </table>
    </div>
    <div class="invoice">

        <table width="95%" border="1">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Level BOM</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Tanggal Dipesan</th>
                    <th scope="col">Tanggal Dibutuhkan</th>
                    <th scope="col">Status</th>

                </tr>
            </thead>

            <tbody>
                @php
                $no =1;
                @endphp

                @foreach ($mrp_BB as $item)
                {{$lvl = $item->Level_BOM?? $item->Level_BOM ??'-'}}
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{$item->BOM_ID}}</td> --}}
                    <td>{{$item->Nama_BahanBaku?? $item->Nama_Part ?? $item->Nama_Produk?? '-'}}</td>

                    <td>
                        @if($lvl == 2)
                        Bahan Baku
                        @elseif($lvl == 1)
                        Part
                        @elseif($lvl == 0)
                        Produk
                        @endif
                    </td>
                    <td>{{$item->sum_POREL??'-'}}</td>
                    <td>{{$item->satuan_BahanBaku?? '-'}}</td>
                    <td>{{$item->Tanggal_Pesan?? '-'}}</td>
                    <td>{{$item->Tanggal_Selesai?? '-'}}</td>
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

                </tr>
                @endforeach

                @foreach ($mrp_etc as $item)
                {{$lvl = $item->BOM->Level_BOM?? $item->Produk->Level_BOM ??'-'}}
                @if ($lvl == 1 OR $lvl == 0)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{$item->BOM->BahanBaku->Nama_BahanBaku?? $item->BOM->Nama_Part ?? $item->Produk->Nama_Produk?? '-'}}</td>
                    <td>
                        @if($lvl == 2)
                        Bahan Baku
                        @elseif($lvl == 1)
                        Part
                        @elseif($lvl == 0)
                        Produk
                        @endif
                    </td>
                    <td>{{$item->POREL??'-'}}</td>
                    <td>
                        @if($lvl == 1)
                        Pcs
                        @elseif($lvl == 0)
                        Pcs
                        @endif
                    </td>
                    <td>{{$item->Tanggal_Pesan}}</td>
                    <td>{{$item->Tanggal_Selesai?? '-'}}</td>
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

                </tr>
                @endif
                @endforeach
            </tbody>
        </table>

    </div>
</body>
</html>
