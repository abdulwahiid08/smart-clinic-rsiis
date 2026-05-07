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
        Schema::create('kunjungans', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('kode_kunjungan')->unique();

            $table->uuid('pasien_id');
            $table->uuid('poli_id');
            $table->uuid('dokter_id');

            $table->date('tanggal_kunjungan');
            $table->enum('jenis_pembayaran', [
                'umum',
                'bpjs',
                'asuransi'
            ])->default('umum');

            $table->enum('status', [
                'terdaftar',
                'sudah_asesmen',
                'batal'
            ])->default('terdaftar');

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();


            // Foreign Key
            $table->foreign('pasien_id')
                ->references('id')
                ->on('pasiens')
                ->cascadeOnDelete();

            $table->foreign('poli_id')
                ->references('id')
                ->on('polis')
                ->cascadeOnDelete();

            $table->foreign('dokter_id')
                ->references('id')
                ->on('dokters')
                ->cascadeOnDelete();

            // Index
            $table->index('kode_kunjungan');
            $table->index('pasien_id');
            $table->index('poli_id');
            $table->index('dokter_id');
            $table->index('tanggal_kunjungan');
            $table->index('jenis_pembayaran');
            $table->index('status');
            $table->index('created_by');

            // Composite Index
            // laporan per tanggal + status
            $table->index([
                'tanggal_kunjungan',
                'status'
            ]);

            // laporan dokter
            $table->index([
                'dokter_id',
                'tanggal_kunjungan'
            ]);

            // riwayat pasien
            $table->index([
                'pasien_id',
                'tanggal_kunjungan'
            ]);

            // filter laporan lengkap
            $table->index([
                'tanggal_kunjungan',
                'dokter_id',
                'status'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
