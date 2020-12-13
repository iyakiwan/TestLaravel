@extends('layouts/app')

@section('content')
<div class="row">
    <div class="col-8">
        <h3>Data Pemasukan</h3>
        <div class="row pl-3" >
            <i class="far fa-calendar-alt mr-3" style="font-size: 25px"></i>
            <form action="{{route('view.pemasukan')}}" method="GET">
                <div class="form-row">
                    <div class="col">
                        <input type="text" id="datepicker" class="form-control" placeholder="From" required name="sort_date_from" value="{{($data != [] && $data->status) ? $data->date_from : ""}}">
                    </div>
                    <div class="col">
                        <input type="text" id="datepicker2" class="form-control" placeholder="To" required name="sort_date_to" value="{{($data != [] && $data->status) ? $data->date_to : ""}}">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-4 text-center">
        <div class="card text-white bg-app mb-3" style="max-width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Total Pemasukan</h5>
                @if ($data == [] || !$data->status)
                    <p class="card-text">RP 0</p>    
                @else
                    <p class="card-text">RP {{number_format($data->jumlah, 0, ',', '.')}}</p>
                @endif
                
            </div>
        </div>
    </div>
</div>
<table class="table ">
    <thead class="bg-app text-white">
    <tr>
        <th scope="col">No</th>
        <th scope="col">Tanggal</th>
        <th scope="col">Kategori</th>
        <th scope="col">Nama</th>
        <th scope="col">Harga</th>
        <th scope="col">Status</th>
    </tr>
    </thead>
    <tbody>
        @if ($data == [] || !$data->status)
            <tr>
                <td align="center" colspan="6">Data tidak ada</td>
            </tr>
        @else
            @foreach ($data->data as $key => $value)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{date('d-m-Y h:m:s', strtotime($value->tanggal))}}</td>
                    <td>{{$value->kategori}}</td>
                    <td>{{$value->nama}}</td>
                    <td>RP {{number_format($value->biaya, 0, ',', '.')}}</td>
                    <td>{{$value->status}}</td>
                </tr>  
            @endforeach
        @endif
    </tbody>
</table>
@endsection
