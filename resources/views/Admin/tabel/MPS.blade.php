@extends('main')
@section('content')
<section class="section">
  <div class="section-header">
    <h1>Data Master MPS</h1>
  </div>
  
  @if (session()->has('statusMPS'))
  <div class="alert alert-success">
    {{session('statusMPS')}}
  </div>
  @endif
  @if (session()->has('hapusMPS'))
  <div class="alert alert-success">
    {{session('hapusMPS')}}
  </div>
  @endif
  @if (session()->has('updateMPS'))
  <div class="alert alert-success">
    {{session('updateMPS')}}
  </div>
  @endif
  <div>
  <a href="/MPS/createMPS" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Data</a>
  </div>
  
  <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Nama</th>
                          <th scope="col">Ukuran</th>
                          <th scope="col">Jumlah</th>
                          <th scope="col">tanggal</th>
                          <th scope="col">Status</th>
                          <th scope="col">aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($MPS as $MPS)
                        <tr>
                          <td>{{ $MPS->ID_MPS }}</td>
                          <td>{{ $MPS->Jumlah_MPS }}</td>
                          <td>{{ $MPS->Tanggal_MPS }}</td>
                          <td>{{ $MPS->Status_MPS }}</td>                          
                          <td>
                            <a href="/Penerimaan/editSUP/{{$MPS->ID_MPS}}" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                            <a href="/Penerimaan/deleteSUP/{{$MPS->ID_MPS}}"  class="btn btn-icon btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i class="fas fa-times"></i></a>
                          </td>
                        </tr>
                        @endforeach 
                      </tbody>
                    </table>

  <div class="section-body">
  </div>
</section>
@endsection