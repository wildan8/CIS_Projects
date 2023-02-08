@foreach($mpsON as $itemMPS)
<div class="rincian">
    <table>
        <b>
            <tr align="left" style="width: 35%;">
                <td><b>Nama Produk : {{$itemMPS->Produk->Nama_Produk }} </b></td>
            </tr>
            <tr>
                <td><b> Status Produksi : {{$itemMPS->status}}</b></td>
            </tr>
            <tr>
                <td> <b> Tanggal Pesan : {{$itemMPS->Tanggal_MPS}}</b></td>
            </tr>
            <tr>
                <td> <b>Ukuran Produk : {{$itemMPS->Produk->Ukuran_Produk}}</b> </td>
            </tr>
        </b>

    </table>
</div>
<div class="invoice">

    <table width="95%" border="1">
        <thead>
            <tr>
                <th scope="col"><b>No</b> </th>
                <th scope="col"> <b>Nama</b></th>
                <th scope="col"> <b>Level BOM</b></th>
                <th scope="col"> <b>Jumlah</b></th>
                <th scope="col"> <b>Satuan</b></th>
                <th scope="col"> <b>tanggal Dipesan</b></th>
                <th scope="col"> <b>tanggal Dibutuhkan</b></th>

            </tr>
        </thead>
        <tbody align="center">

            @php
            $no =1;
            @endphp

            @foreach ($mrp_BB as $itemMRP)
            @if ($itemMRP->MPS_ID == $itemMPS->ID_MPS)
            @if ($itemMRP->BOM_ID != null)

            <tr>
                <td>{{ $no++ }}</td>
                <td>{{$itemMRP->Nama_BahanBaku?? $itemMRP->Nama_Part ?? $itemMRP->Nama_Produk?? '-'}}</td>
                {{$lvl = $itemMRP->Level_BOM?? $itemMRP->Level_BOM ??'-'}}
                <td>
                    @if($lvl == 2)
                    Bahan Baku
                    @elseif($lvl == 1)
                    Part
                    @elseif($lvl == 0)
                    Produk
                    @endif
                </td>
                <td>{{$itemMRP->sum_POREL??'-'}}</td>
                <td>
                    @if($lvl == 2)
                    Bahan Baku
                    @elseif($lvl == 1)
                    Part
                    @elseif($lvl == 0)
                    Produk
                    @endif
                </td>
                <td>{{$itemMRP->Tanggal_Pesan?? '-'}}</td>
                <td>{{$itemMRP->Tanggal_Selesai?? '-'}}</td>
            </tr>
            @endif
            @endif
            @endforeach

            @foreach ($mrp_etc as $itemMRP)
            @if ($itemMRP->MPS_ID == $itemMPS->ID_MPS)

            {{$lvl = $itemMRP->BOM->Level_BOM?? $itemMRP->Produk->Level_BOM ??'-'}}
            @if ($lvl == 1 OR $lvl == 0)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{$itemMRP->BOM->BahanBaku->Nama_BahanBaku?? $itemMRP->BOM->Nama_Part ?? $itemMRP->Produk->Nama_Produk?? '-'}}</td>
                <td>
                    @if($lvl == 2)
                    Bahan Baku
                    @elseif($lvl == 1)
                    Part
                    @elseif($lvl == 0)
                    Produk
                    @endif
                </td>
                <td>{{$itemMRP->POREL??'-'}}</td>
                <td>
                    @if($lvl == 1)
                    Pcs
                    @elseif($lvl == 0)
                    Pcs
                    @endif
                </td>
                <td>{{$itemMRP->Tanggal_Pesan}}</td>
                <td>{{$itemMRP->Tanggal_Selesai?? '-'}}</td>
            </tr>
            @endif
            @endif

            @endforeach

        </tbody>
    </table>

</div>
@endforeach
