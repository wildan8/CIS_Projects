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
           
            <!-- <input type="text" name="Produk_ID" id="Produk_ID"  class="form-control @error('Jumlah_MPS') is-invalid @enderror" required > -->
            
            <select class="form-control" name ="Produk_ID" id="Produk_ID" >
              <option disabled value>-- Pilih Produk --</option>
              @foreach ($PR as $PR)
              <option value="{{ $PR->ID_Produk }}">{{ $PR->Nama_Produk.' ( '.$PR->Ukuran_Produk.' ) ' }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-12">
            <label>Ukuran</label>
            <input type="text" name="Ukuran_Produk" id="Ukuran_Produk" value="" class="form-control ">            
          </div>
          <div class="form-group col-12">
            <label>Jumlah Pesanan</label>
            <input type="text" name="Jumlah_MPS" value="{{old('Jumlah_MPS')}}" class="form-control @error('Jumlah_MPS') is-invalid @enderror" required >
            
          </div>
          <div class="form-group col-12">
            <label>Tanggal Pembuatan Pesanan</label>
            <input type="date" name="Tanggal_MPS" value="{{old('Tanggal_MPS')}}" class="form-control @error('Tanggal_MPS') is-invalid @enderror" required >
            
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

<script>
  const produkID = document.querySelector('#Produk_ID');
  const ukuranProduk = document.querySelector('#Ukuran_Produk');

  Produk_ID.addEventListener('click', function(){
    fetch ('/MPS/createMPS/fetch?Produk_ID='+produkID.value)
      .then(response => response.json())
      .then(data => ukuranProduk.value = JSON.parse(data.ukuranProduk));
  });
  
</script>
@endsection

