<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perpanjangan_sewa', function (Blueprint $table) {
            $table->string('perpanjangan_id', 30)->primary();
            $table->string('sewa_id', 30);
            $table->dateTime('tanggal_selesai_lama');
            $table->dateTime('tanggal_selesai_baru');
            $table->decimal('biaya_tambahan', 15, 2);
            $table->string('bukti_bayar', 255);
            $table->unsignedBigInteger('admin_nik');
            $table->timestamps();

            $table->foreign('sewa_id')->references('sewa_id')->on('sewa_garasi')->onDelete('cascade');
            $table->foreign('admin_nik')->references('nik')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perpanjangan_sewa');
    }
};
