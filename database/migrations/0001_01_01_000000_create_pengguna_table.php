<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap')->nullable();
            $table->enum('pend',['<= SMA','DIPLOMA D1/D2/D3','S1','S2','S3'])->nullable();
            $table->enum('kelamin',['Laki-Laki','Perempuan'])->nullable();
            $table->string('pekerj')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
