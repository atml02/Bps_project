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
        Schema::create('riwayat', function (Blueprint $table) {
            $table->id();
            $table->string('kepada');
            $table->string('pengirim');

            // Untuk reservasi_id Harus dilakukan manual di Db Terminal
            // Berikut codenya
            
//             DELIMITER $$

// CREATE TRIGGER before_user_delete
// BEFORE DELETE ON users
// FOR EACH ROW
// BEGIN
//     DELETE FROM reservasi WHERE user_id = OLD.id;
//     DELETE FROM riwayat WHERE reservasi_id IN (SELECT id FROM reservasi WHERE user_id = OLD.id);
// END$$

// DELIMITER ;

// ALTER TABLE `riwayat`
// ADD CONSTRAINT `fk_riwayat_reservasi_id`
// FOREIGN KEY (`reservasi_id`) REFERENCES `reservasi`(`id`)
// ON DELETE CASCADE;


            $table->foreignId('reservasi_id');
                // ->constrained('reservasi')
                // ->onDelete('cascade'); // Opsi cascade delete H

            $table->string('subjek')->nullable();
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat');
    }
};
