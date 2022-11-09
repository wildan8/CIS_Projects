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
                                <option disabled value>-- Pilih Produk --</option>
                                @foreach ($PR as $PR)
                                <option value="{{ $PR->ID_Produk }}">{{ $PR->Nama_Produk}}</option>
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
            var Produk_ID = $(this).val();
            var _token = $('input[name="_token"]').val();
            if (Produk_ID) {
                $.ajax({
                    url: '/createMPS/fetchProduk/' + Produk_ID
                    , type: "GET"
                    , data: {
                        "_token": _token
                    }
                    , dataType: "json"
                    , success: function(data) {
                        if (data) {
                            $('#Ukuran_Produk').empty();
                            $('#Ukuran_Produk').append('<option hidden>Pilih Ukuran Produk</option>');
                            $.each(data, function(key, Ukuran_Produk) {
                                $('select[name="Ukuran_Produk"]').append('<option value="' + key + '">' + Ukuran_Produk.name + '</option>');
                            });
                        } else {
                            $('#Ukuran_Produk').empty();
                        }
                    }
                });
            } else {
                $('#Ukuran_Produk').empty();
            }
        });
    });

</script>

@endpush
