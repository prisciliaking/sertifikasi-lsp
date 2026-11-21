<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sewa_garasi', function (Blueprint $table) {
            $table->string('sewa_id', 30)->primary();
            $table->unsignedBigInteger('nik');
            $table->string('kendaraan_id', 30);
            $table->string('garasi_id', 10);
            $table->string('tipe_sewa', 10); // harian, bulanan
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->decimal('sisa_baterai_awal', 5, 2)->nullable(); // persentase 0-100
            $table->decimal('biaya_sewa', 15, 2);
            $table->decimal('biaya_listrik', 15, 2)->default(0);
            $table->decimal('total_biaya', 15, 2);
            $table->string('bukti_bayar', 255);
            $table->timestamps();

            $table->foreign('nik')->references('nik')->on('users')->onDelete('restrict');
            $table->foreign('kendaraan_id')->references('kendaraan_id')->on('kendaraan')->onDelete('restrict');
            $table->foreign('garasi_id')->references('garasi_id')->on('garasi')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sewa_garasi');
    }
};
