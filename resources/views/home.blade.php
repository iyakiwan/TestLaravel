@extends('layouts/app')

@section('content')
    <center>
        <img src="{{asset('images/logo-no-bg.png')}}" alt="">
        <div class="row w-75 pt-5">
            <div class="col-4">
                <div class="mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Validasi Arus Kas</h6>
                        <a href="{{url('validasi')}}">
                            <img src="{{asset('images/poster1.png')}}"
                                 class="w-75" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Laporan Arus Keluar Masuk</h6>
                        <a href="{{url('arus')}}">
                            <img src="{{asset('images/poster2.png')}}"
                                 class="w-75" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Laporan Bulanan</h6>
                        <a href="{{url('bulanan')}}">
                            <img src="{{asset('images/poster3.png')}}"
                                 class="w-75" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Status Transaksi</h6>
                        <a href="{{url('status')}}">
                            <img src="{{asset('images/poster4.png')}}"
                                 class="w-75" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Data Pemasukan</h6>
                        <a href="{{url('pemasukan')}}">
                            <img src="{{asset('images/poster5.png')}}"
                                 class="w-75" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Data Pengeluaran</h6>
                        <a href="{{url('pengeluaran')}}">
                            <img src="{{asset('images/poster6.png')}}"
                                 class="w-75" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </center>
@endsection
