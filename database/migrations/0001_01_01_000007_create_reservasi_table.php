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
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade'); // Opsi cascade delete
            $table->foreignId('kegiatan_id')->constrained(
                table: 'kegiatan',
                indexName: 'kegiatan_id'
            );
            $table->foreignId('riwayat_id')->nullable()
                ->constrained('riwayat')
                ->onDelete('cascade'); // Opsi cascade delete
            $table->dateTime('tgl_req');
            $table->enum('wkt_req', ['Sesi Pagi (08.00-12.00)', 'Sesi Siang (13.00-16.00)']);
            $table->string('temu_req')->nullable();
            $table->enum('plat_req', ['WhatsApp', 'Zoom Meeting', 'Google Meet'])->nullable();
            $table->string('keperluan')->nullable();
            $table->enum('status', ['proses', 'disetujui', 'ditolak'])->default('proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
