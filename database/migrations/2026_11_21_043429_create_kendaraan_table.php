<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->string('kendaraan_id', 30)->primary();
            $table->string('tipe_kendaraan', 30); // sepeda, sepeda motor, mobil, mobil listrik
            $table->decimal('kapasitas_baterai', 5, 2)->nullable();
            $table->string('plat_nomor', 15)->nullable();
            $table->string('merek_kendaraan', 30);
            $table->string('model_merek', 30);
            $table->unsignedBigInteger('nik');
            $table->timestamps();

            $table->foreign('nik')
                ->references('nik')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
