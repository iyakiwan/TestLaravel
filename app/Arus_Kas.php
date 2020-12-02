<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arus_Kas extends Model
{
    protected $table = 'arus_kas';

    protected $fillable = [
        'transaksi_id', 'arus', 'jenis', 'nama', 'keterangan', 'divisi', 'total_biaya', 'status', 'id_pegawai'
    ];
}
