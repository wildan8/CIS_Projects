@extends('main')
@section('content')
<section class="section">
  <div class="section-header">
    <h1>Form Data Bill of Material</h1>
  </div>

  <form action="/BOM/createBOM" method="post">
    @csrf
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="form-group col-12">
              <label>Produk</label>
              <select class="form-control" name ="Produk_ID" id="Produk_ID">
                <option disabled value>-- Pilih Produk --</option>
                @foreach ($PROD as $s)
                <option value="{{ $s->ID_Produk }}">{{ $s->Nama_Produk }}</option>
                @endforeach
              </select>
            </div>        
            <div class="form-group col-12">
              <label>Bahan Baku</label>
              <select class="form-control" name ="BahanBaku_ID" id="BahanBaku_ID">
                <option disabled value>-- Pilih Bahan Baku --</option>
                @foreach ($BB as $bb)
                <option value="{{ $bb->ID_BahanBaku }}">{{ $bb->Nama_BahanBaku }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-12">
              <label>Jumlah</label>
              <input type="text" name="Jumlah_BOM" class="form-control">
            </div>
            <div class="form-group col-12">
              <label>Ukuran Produk</label>
              <input type="text" name="Ukuran_Produk" class="form-control">
            </div>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Nama</th>                          
                  <th scope="col">Jumlah</th>
                  <th scope="col">aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>@mdo</td> 
                  <td>@mdo</td>                       
                  <td>
                    <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                  </td>
                </tr>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>@mdo</td>  
                  <td>@mdo</td>                      
                  <td>
                    <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                  </td>
                </tr>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>@mdo</td> 
                  <td>@mdo</td>                       
                  <td>
                    <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                  </td>
                </tr>
              </tbody>
            </table>
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