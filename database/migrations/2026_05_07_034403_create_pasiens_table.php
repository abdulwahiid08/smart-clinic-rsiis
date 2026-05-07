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
        Schema::create('pasiens', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('kode_pasien')->unique();
            $table->string('nama_pasien');
            $table->enum('jenis_kelamin', [
                'L',
                'P'
            ]);

            $table->date('tanggal_lahir')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->text('alamat')->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();


            // Index
            $table->index('kode_pasien');
            $table->index('nama_pasien');
            $table->index('created_by');

            // Composite Index
            $table->index([
                'nama_pasien',
                'tanggal_lahir'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
