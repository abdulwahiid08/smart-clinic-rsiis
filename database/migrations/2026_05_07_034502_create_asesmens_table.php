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
        Schema::create('asesmens', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('kunjungan_id')->unique();

            $table->text('keluhan_utama');

            $table->string('tekanan_darah')->nullable();

            $table->decimal('suhu_tubuh', 4, 1)->nullable();

            $table->decimal('berat_badan', 5, 2)->nullable();

            $table->text('diagnosis_awal');

            $table->text('tindakan_terapi')->nullable();

            $table->text('catatan_dokter')->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();

            $table->timestamps();

            // Foreign Key
            $table->foreign('kunjungan_id')
                ->references('id')
                ->on('kunjungans')
                ->cascadeOnDelete();


            // Index
            $table->index('kunjungan_id');
            $table->index('created_by');


            // Full Text Index
            // MySQL InnoDB support fulltext
            $table->fullText('diagnosis_awal');
            $table->fullText('keluhan_utama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesmens');
    }
};
