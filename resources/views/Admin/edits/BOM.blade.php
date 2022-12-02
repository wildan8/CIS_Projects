@extends('main')
@section('content')
<section class="section">

    <-- Kembali</a>
        </div>


        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <input type="text" class="form-control" name="Produk_ID" value="{{ $Produk->ID_Produk }}">

                        <div class="form-group col-12">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" name="Nama_Produk" value="{{ $Produk->Nama_Produk }}" disabled>

                        </div>
                        <div class="form-group col-12">
                            <label>Ukuran</label>
                            <input type="text" class="form-control" name="Ukuran_Tampil" value="{{ $Produk->Ukuran_Produk }}" disabled>
                            <input type="text" class="form-control" name="Ukuran_Produk" value="{{ $Produk->Ukuran_Produk }}" hidden>
                        </div>

                        <div class="form-group col-12">
                            <label>Tipe</label>
                            <select class="form-control" name="Tipe_BOM" id="Tipe_BOM">
                                <option>-- Pilih Tipe --</option>
                                <option value="Parts"> Bagian Komponen (Parts) </option>
                                <option value="BahanBaku">Bahan Baku</option>
                            </select>
                        </div>

                        <div class="form-group col-12" id="Select_Parts">
                            <label>Nama Parts</label>
                            <select class="form-control" name="Select_Parts">
                                <option disabled value>-- Pilih parts --</option>
                                @foreach ($Parts as $Parts)
                                <option value="{{ $Parts->ID_BOM }}">{{ $Parts->Nama_Part }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-12" id="BahanBaku_ID">
                            <label>Nama Bahan Baku</label>
                            <select class="form-control" name="BahanBaku_ID">
                                <option value="">-- Pilih Bahan Baku --</option>
                                @foreach ($BB as $BB)
                                <option value="{{ $BB->ID_BahanBaku }}">{{ $BB->Nama_BahanBaku }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12" id="Nama_Parts">
                            <label>Nama Parts</label>
                            <input type="text" class="form-control" name="Nama_Part">

                        </div>
                        <div class="form-group col-12" id="Leadtime_BOM">
                            <label>Leadtime</label>
                            <input type="text" class="form-control @error('Leadtime_BOM') is-invalid @enderror" name="Leadtime_BOM">
                            @error('Leadtime_BOM')
                            <div class="invalid-feedback">
                                Isi Dengan Jumlah Produk.
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-12" id="Jumlah_BOM">
                            <label>Jumlah</label>
                            <input type="text" class="form-control @error('Jumlah_BOM') is-invalid @enderror" name="Jumlah_BOM" required>
                            @error('Jumlah_BOM')
                            <div class="invalid-feedback">
                                Isi Dengan Jumlah Produk.
                            </div>
                            @enderror
                        </div>

                        <div class="buttons col-12">
                        </div>
                        <div>
                            <button type="submit" class="btn m-2  btn-primary">Simpan Data</button>
                            <a href="/BOM/export/{{$Produk->ID_Produk}}" class="btn btn-icon icon-right  m-2 btn-danger"> Export
                                Data</a>
                        </div>

                        {{-- Table parts --}}
                        <div class="section-body">
                            <div class="card">
                                <div class="table-responsive p-2">
                                    <table class="  table table-striped table-md ">
                                        <thead>
                                            <tr>
                                                <th scope="col">Kode BOM</th>
                                                <th scope="col">Nama Part</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Leadtime</th>
                                                <th scope="col">aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($P as $p)
                                            <tr>
                                                <td>{{ $p->Kode_BOM?? '-' }}</td>
                                                <td>{{ $p->Nama_Part?? '-' }}</td>
                                                <td>{{ $p->Jumlah_BOM }}</td>
                                                <td>{{ $p->Leadtime_BOM }}</td>

                                                <td>
                                                    <a href="/BOM/deletePartsBOM/{{ $p->ID_BOM }}" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i class="fas fa-times"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- End Table parts --}}
                        <!-- table Page -->
                        <div class="section-body">
                            <div class="card">
                                <div class="table-responsive p-2">
                                    <table class="  table table-striped table-md ">
                                        <thead>
                                            <tr>
                                                <th scope="col">Kode BOM</th>
                                                <th scope="col">Nama Parts</th>
                                                <th scope="col">Nama Bahan Baku</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($BOM as $BOM)
                                            <tr>
                                                <td>{{ $BOM->Kode_BOM?? '-' }}</td>
                                                <td>{{ $BOM->Nama_Part?? '-' }}</td>
                                                <td>{{ $BOM->BahanBaku->Nama_BahanBaku?? '-' }}</td>
                                                <td>{{ $BOM->Jumlah_BOM }}</td>
                                                <td>
                                                    <a href="/BOM/deleteBBBOM/{{ $BOM->ID_BOM }}" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i class="fas fa-times"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <!-- End Table Page -->
                    </div>
                </div>
            </div>
        </div>


</section>
@endsection

@push('javascript-internal')
<script>
    $(function() {
        $("#Leadtime_BOM").hide();
        $('#BahanBaku_ID').hide();
        $('#Jumlah_BOM').hide();
        $('#Nama_Parts').hide();
        $('#Select_Parts').hide();

        $("#Tipe_BOM").change(function() {
            if ($(this).val() == "Parts") {
                $('#BahanBaku_ID').hide();
                $('#Nama_Parts').show();
                $("#Leadtime_BOM").show();
                $('#Jumlah_BOM').show();
                $('#Select_Parts').hide();
            } else if ($(this).val() == "BahanBaku") {
                $('#Select_Parts').show();
                $('#BahanBaku_ID').show();
                $('#Nama_Parts').hide();
                $("#Leadtime_BOM").hide();
                $('#Jumlah_BOM').show();
            } else {
                $('#BahanBaku_ID').hide();
                $("#Leadtime_BOM").hide();
                $('#Jumlah_BOM').hide();
                $('#Nama_Parts').hide();
                $('#Select_Parts').hide();
            }

        });
    });

</script>
@endpush
