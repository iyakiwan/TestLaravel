@extends('layouts/app')

@section('content')
<div class="row">
    <div class="col-8">
        <h3>Laporan Bulanan</h3>
        <div class="row pl-3" >
            <i class="far fa-calendar-alt mr-3" style="font-size: 25px"></i>
            <form action="{{route('view.labarugi')}}" method="GET">
                <div class="form-row">
                    @if ($data != [] && $data->status)
                        <div class="col">
                            <select class="form-control" name="sort_month" required>
                                <option value="">Bulan</option>
                                <option value="1" {{$data->bulan == "1"  ? 'selected' : ''}}>Januari</option>
                                <option value="2" {{$data->bulan == "2"  ? 'selected' : ''}}>Februari</option>
                                <option value="3" {{$data->bulan == "3"  ? 'selected' : ''}}>Maret</option>
                                <option value="4" {{$data->bulan == "4"  ? 'selected' : ''}}>April</option>
                                <option value="5" {{$data->bulan == "5"  ? 'selected' : ''}}>Mei</option>
                                <option value="6" {{$data->bulan == "6"  ? 'selected' : ''}}>Juni</option>
                                <option value="7" {{$data->bulan == "7"  ? 'selected' : ''}}>Juli</option>
                                <option value="8" {{$data->bulan == "8"  ? 'selected' : ''}}>Agustus</option>
                                <option value="9" {{$data->bulan == "9"  ? 'selected' : ''}}>September</option>
                                <option value="10" {{$data->bulan == "10"  ? 'selected' : ''}}>Oktober</option>
                                <option value="11" {{$data->bulan == "11"  ? 'selected' : ''}}>November</option>
                                <option value="12" {{$data->bulan == "12"  ? 'selected' : ''}}>Desember</option>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control" name="sort_year" required>
                                <option value="">Tahun</option>
                                <option value="2015" {{$data->tahun == "2015"  ? 'selected' : ''}}>2015</option>
                                <option value="2016" {{$data->tahun == "2016"  ? 'selected' : ''}}>2016</option>
                                <option value="2017" {{$data->tahun == "2017"  ? 'selected' : ''}}>2017</option>
                                <option value="2018" {{$data->tahun == "2018"  ? 'selected' : ''}}>2018</option>
                                <option value="2019" {{$data->tahun == "2019"  ? 'selected' : ''}}>2019</option>
                                <option value="2020" {{$data->tahun == "2020"  ? 'selected' : ''}}>2020</option>
                                <option value="2021" {{$data->tahun == "2021"  ? 'selected' : ''}}>2021</option>
                                <option value="2022" {{$data->tahun == "2022"  ? 'selected' : ''}}>2022</option>
                                <option value="2023" {{$data->tahun == "2023"  ? 'selected' : ''}}>2023</option>
                                <option value="2024" {{$data->tahun == "2024"  ? 'selected' : ''}}>2024</option>
                            </select>
                        </div>
                    @else
                    <div class="col">
                        <select class="form-control" name="sort_month" required>
                            <option value="">Bulan</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" name="sort_year" required>
                            <option value="">Tahun</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                    @endif
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
                @if ($data != [] && $data->status)
                    <h5 class="card-title">Total Bulanan ({{($data->laba) ? "Untung":"Rugi"}})</h5>
                    <p class="card-text">RP {{number_format($data->hasil, 0, ',', '.')}}</p>
                @else
                    <h5 class="card-title">Total Bulanan</h5>
                    <p class="card-text">RP 0</p>
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
        <th scope="col">Deskripsi</th>
        <th scope="col">Jumlah</th>
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
                    <td>
                        @if ($value->arus == "masuk")
                        + Rp {{number_format($value->biaya, 0, ',', '.')}}   
                        @else
                        - Rp {{number_format($value->biaya, 0, ',', '.')}}
                        @endif
                    </td>
                    <td>{{$value->status}}</td>
                </tr>  
            @endforeach
        @endif
    </tbody>
</table>
@endsection
