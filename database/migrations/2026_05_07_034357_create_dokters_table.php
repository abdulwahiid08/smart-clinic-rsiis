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
        Schema::create('dokters', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('poli_id');

            $table->string('nama_dokter');
            $table->string('spesialis')->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('poli_id')
                ->references('id')
                ->on('polis')
                ->cascadeOnDelete();

            // Index
            $table->index('poli_id');
            $table->index('nama_dokter');
            $table->index('created_by');

            // Composite Index
            $table->index([
                'poli_id',
                'nama_dokter'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokters');
    }
};
