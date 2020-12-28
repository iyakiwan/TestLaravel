<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArusKasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arus_kas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('transaksi_id');
            $table->enum('arus', ['masuk', 'keluar']);
            $table->enum('jenis', ['pengiklanan', 'pembelian', 'penggajian', 'pengadaan']);
            $table->string('nama', 191);
            $table->text('keterangan')->nullable();;
            $table->enum('divisi', ['sales', 'sdm','warehouse','finance']);
            $table->decimal('total_biaya', 15, 2);
            $table->enum('status', ['menunggu', 'diterima','ditolak']);
            $table->integer('id_pegawai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arus_kas');
    }
}
