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
    <center>
        <h1>List Data Supplier</h1>
    </center>
    <div class="invoice">
        <div class="rincian">
            <table>
                <tr>
                    <td align="left" style="width: 35%;">
                        <bold>Judul:</bold> {{$Judul }} <br>
                        <bold>Tanggal Pembuatan:</bold> {{$Tanggal}} <br>
                        <bold>Jumlah Data:</bold> {{$Jumlah}}
                    </td>
                </tr>
            </table>
        </div>
        <div class="invoice">

            <table width="95%" border="1">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode Supplier</th>
                        <th scope="col">Nama Usaha</th>
                        <th scope="col">Pemilik Usaha</th>
                        <th scope="col">Alamat Usaha</th>
                        <th scope="col">Nomor Telepon</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @php
                    $no =1;
                    @endphp
                    @foreach ($data as $supplier)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $supplier->Kode_Supplier }}</td>
                        <td>{{ $supplier->Nama_Supplier }}</td>
                        <td> {{ $supplier->Pemilik_Supplier }} </td>
                        <td> {{ $supplier->Alamat_Supplier }} </td>
                        <td> {{ $supplier->Telp_Supplier }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</body>
</html>
