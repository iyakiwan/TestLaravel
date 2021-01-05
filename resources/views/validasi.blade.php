@extends('layouts/app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>Validasi Arus Kas</h3>
        </div>
    </div>
    <table class="table mt-5">
        <thead class="bg-app text-white">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Jenis</th>
            <th scope="col">Kategori</th>
            <th scope="col">Divisi</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Status</th>
            <th scope="col">Validasi</th>
        </tr>
        </thead>
        <tbody>
            @if ($data == [] || !$data->status)
                <tr>
                    <td align="center" colspan="6">Data tidak ada</td>
                </tr>
            @else
                {{$no = 1}}
                @foreach ($data->data as $key => $value)
                    @if ($value->status == "menunggu")
                        <tr>
                            <th scope="row">{{$no++}}</th>
                            <td>{{date('d-m-Y h:m:s', strtotime($value->created_at))}}</td>
                            <td>{{$value->arus}}</td>
                            <td>{{$value->jenis}}</td>
                            <td>{{$value->divisi}}</td>
                            <td>
                                @if ($value->arus == "masuk")
                                + Rp {{number_format($value->total_biaya, 0, ',', '.')}}   
                                @else
                                - Rp {{number_format($value->total_biaya, 0, ',', '.')}}
                                @endif
                            </td>
                            <td>{{$value->status}}</td>
                            <td><a href="{{route('view.validation', $value->id)}}" class="btn btn-primary">Validasi</a></td>
                        </tr> 
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
