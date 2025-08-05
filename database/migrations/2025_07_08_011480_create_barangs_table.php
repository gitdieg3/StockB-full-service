<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->unsignedBigInteger('tipe_barang_id');
            $table->unsignedBigInteger('status_barang_id');
            $table->integer('jumlah');
            $table->unsignedBigInteger('jasa_kirim_id')->nullable();
            $table->date('tanggal_masuk')->nullable();

            $table->timestamps();

            // Relasi ke tabel lain
            $table->foreign('tipe_barang_id')->references('id')->on('tipe_barangs')->onDelete('cascade');
            $table->foreign('status_barang_id')->references('id')->on('status_barangs')->onDelete('cascade');
           $table->foreign('jasa_kirim_id')->references('id')->on('jasa_kirims')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
