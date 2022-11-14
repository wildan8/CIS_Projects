@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Form Data MPS</h1>
    </div>


    <form action="/MPS/storeMPS" method="post">
        @csrf
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="form-group col-12">
                            <label>Produk</label>


                            <select class="form-control" name="Produk_ID" id="Produk_ID" data-placeholder="Select">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($PR as $PR)
                                <option value="{{ $PR->Nama_Produk }}">{{ $PR->Nama_Produk}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>Ukuran</label>
                            <select class="form-control" name="Ukuran_Produk" id="Ukuran_Produk" data-placeholder="Select">


                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label>Jumlah Pesanan</label>
                            <input type="text" name="Jumlah_MPS" value="{{old('Jumlah_MPS')}}" class="form-control @error('Jumlah_MPS') is-invalid @enderror" required>

                        </div>
                        <div class="form-group col-12">
                            <label>Tanggal Pembuatan Pesanan</label>
                            <input type="date" name="Tanggal_MPS" value="{{old('Tanggal_MPS')}}" class="form-control @error('Tanggal_MPS') is-invalid @enderror" required>

                        </div>
                        <div class="buttons col-12">
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

</section>
@endsection

@push('javascript-internal')

<script>
    $(document).ready(function() {
        $('#Produk_ID').on('change', function() {
            var Produk_ID = this.value;
            $("#Ukuran_Produk").html('');
            $.ajax({
                url: "{{url('/MPS/createMPS/fetchProduk')}}"
                , type: "POST"
                , data: {
                    Produk_ID: Produk_ID
                    , _token: '{{csrf_token()}}'
                }
                , dataType: 'json'
                , success: function(result) {
                    $('#Ukuran_Produk').html('<option value="">-- Select Ukuran Produk --</option>');
                    $.each(result.produks, function(key, value) {
                        $("#Ukuran_Produk").append('<option value="' + value
                            .Ukuran_Produk + '">' + value.Ukuran_Produk + '</option>');
                    });

                }
            });
        });

    });

</script>


@endpush
