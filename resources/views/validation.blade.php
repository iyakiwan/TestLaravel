@extends('layouts/app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>Validasi Arus Kas</h3>
        </div>
        <div class="col-4 text-center">
        </div>
    </div>
    <div class="mt-3 ml-3">
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <h5>Data Transaksi</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Tanggal
                    </div>
                    <div class="col-8">
                        : {{date('d M Y', strtotime($data->data->created_at))}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Jam
                    </div>
                    <div class="col-8">
                        : {{date('h:m:s', strtotime($data->data->created_at))}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Jenis
                    </div>
                    <div class="col-8">
                        : {{$data->data->arus}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Nama Transaksi
                    </div>
                    <div class="col-8">
                        : {{$data->data->nama}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Deskripsi Transaksi
                    </div>
                    <div class="col-8">
                        : {{$data->data->keterangan}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Divisi
                    </div>
                    <div class="col-8">
                        : {{$data->data->divisi}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Total Biaya
                    </div>
                    <div class="col-8">
                        : Rp {{number_format($data->data->total_biaya, 0, ',', '.')}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Penanggung Jawab
                    </div>
                    <div class="col-8">
                        : {{$data_pegawai->data->username}} ({{$data_pegawai->data->role}}, {{$data->data->divisi}})
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Status
                    </div>
                    <div class="col-8">
                        : {{$data->data->status}}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <h5>Data Kas</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Tanggal
                    </div>
                    <div class="col-8">
                        : {{date('d M Y', strtotime($data_validasi['datetime']))}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Jam
                    </div>
                    <div class="col-8">
                        : {{date('h:m:s', strtotime($data_validasi['datetime']))}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Jenis
                    </div>
                    <div class="col-8">
                        : {{$data_validasi['jenis']}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Nama Transaksi
                    </div>
                    <div class="col-8">
                        : {{$data_validasi['name']}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Deskripsi Transaksi
                    </div>
                    <div class="col-8">
                        : {{$data_validasi['desc']}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Divisi
                    </div>
                    <div class="col-8">
                        : {{$data_validasi['divisi']}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Total Biaya
                    </div>
                    <div class="col-8">
                        : Rp {{number_format($data_validasi['total'], 0, ',', '.')}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Status
                    </div>
                    <div class="col-8">
                        : {{$data_validasi['status']}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <h4>Aksi Validasi Arus Kas</h4>
            </div>
            <div class="col-12">
                <form action="{{route('view.validation.action', $data->data->id)}}" method="POST">
                    @csrf 
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="menunggu">Menunggu</option>
                            <option value="diterima">Terima</option>
                            <option value="ditolak">Tolak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
