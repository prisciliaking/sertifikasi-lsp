<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garasi', function (Blueprint $table) {
            $table->string('garasi_id', 10)->primary(); // S001, C001, E001
            $table->string('tipe_garasi', 30); // sepeda, mobil, mobil listrik
            $table->decimal('harga_sewa', 15, 2);
            $table->decimal('harga_per_kwh', 15, 2)->nullable();
            $table->boolean('status_sewa')->default(false); // 0 = available, 1 = used
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garasi');
    }
};
