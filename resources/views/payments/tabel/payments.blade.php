@extends('payments.layouts.main')
@section('content')
<section class="section">
  <div class="section-header">
    <h1>Data Master MPS</h1>
  </div>
  <div>
  <a href="/Bahanbaku/createBB" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Data</a>
  </div>
  
  <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">ID BOM</th>
                          <th scope="col">ID Payment</th>
                          <th scope="col">Nama Bahan Baku</th>                          
                          <th scope="col">harga Satuan</th>
                          <th scope="col">Tanggal</th>
                          <th scope="col">Status</th>
                          <th scope="col">aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($payment as $payment)
                        <tr>
                          <td> Id BOM (Foreign key)</td>                          
                          <td>{{ $payment->ID_Payment }}</td>
                          <td>Nama Bahan Baku (Foreign Key)</td>
                          <td>{{ $payment->Harga_Payment }}</td>
                          <td>{{ $payment->Tanggal_Payment }}</td>
                          <td>{{ $payment->Status_Payment }}</td>                          
                          <td>
                            <a href="/Payment/editPay/{{$payment->ID_Payment}}" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                            <a href="/Payment/deletePay/{{$payment->ID_Payment}}"  class="btn btn-icon btn-danger" onclick="return confirm('yakin?')"><i class="fas fa-times"></i></a>
                          </td>
                        </tr>
                        @endforeach 
                      </tbody>
                    </table>

  <div class="section-body">
  </div>
</section>
@endsection