@extends('layouts/app')

@section('content')
    <div class="row">
        <div class="col-8">
            <h3>Data Arus Kas</h3>
            <div class="row pl-3">
                <i class="far fa-calendar-alt mr-3" style="font-size: 25px"></i>
                <form>
                    <div class="form-row">
                        <div class="col">
                            <input type="text" id="datepicker" class="form-control" placeholder="From">
                        </div>
                        <div class="col">
                            <input type="text" id="datepicker2" class="form-control" placeholder="To">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-4 text-center">
            <div class="d-flex align-items-end flex-column">
                <div class="mb-4">
                </div>
                <div class="mt-auto p-2">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalTambah">
                        Tambah Data Kas
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Arus</label>
                                    <select name="arus" id="" class="form-control">
                                        <option value="">Masuk</option>
                                        <option value="">Keluar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Jenis</label>
                                    <select name="jenis" id="" class="form-control">
                                        <option value="">Pembelian</option>
                                        <option value="">Pembayaran</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Divisi</label>
                                    <select name="divisi" id="" class="form-control">
                                        <option value="">Sales</option>
                                        <option value="">Logistik</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-8">
                                <div class="form-group">
                                    <label>Pegawai</label>
                                    <select name="Pegawai" id="" class="form-control">
                                        <option value="">Joko</option>
                                        <option value="">Hurra</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Biaya</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp. </span>
                                </div>
                                <input type="number" class="form-control" a">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="" cols="30" rows="5"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="button" class="btn btn-success">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
    <table class="table mt-5">
        <thead class="bg-app text-white">
        <tr>
            <th scope="col">Tanggal</th>
            <th scope="col">Kategori</th>
            <th scope="col">Deskripsi</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <th scope="row"></th>
            <td>Jacob</td>
            <td>Jacob</td>
            <td>@fat</td>
            <td>@fat</td>
            <td>
                <div class="row ">
                    <div class="col-2">
                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEdit">
                            Edit
                        </button>
                    </div>
                    <div class="col-2">
                        <form action="">
                            <button type="submit" class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Kas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Arus</label>
                                    <select name="arus" id="" class="form-control">
                                        <option value="">Masuk</option>
                                        <option value="">Keluar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Jenis</label>
                                    <select name="jenis" id="" class="form-control">
                                        <option value="">Pembelian</option>
                                        <option value="">Pembayaran</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Divisi</label>
                                    <select name="divisi" id="" class="form-control">
                                        <option value="">Sales</option>
                                        <option value="">Logistik</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-8">
                                <div class="form-group">
                                    <label>Pegawai</label>
                                    <select name="Pegawai" id="" class="form-control">
                                        <option value="">Joko</option>
                                        <option value="">Hurra</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Biaya</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp. </span>
                                </div>
                                <input type="number" class="form-control" a">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="" cols="30" rows="5"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="button" class="btn btn-success">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
@endsection
