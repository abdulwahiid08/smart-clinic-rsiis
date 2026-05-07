<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('kunjungans', 'jenis_pembayaran')) {
            Schema::table('kunjungans', function (Blueprint $table) {
                $table->enum('jenis_pembayaran', [
                    'umum',
                    'bpjs',
                    'asuransi',
                ])->default('umum')->after('tanggal_kunjungan');

                $table->index('jenis_pembayaran');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('kunjungans', 'jenis_pembayaran')) {
            Schema::table('kunjungans', function (Blueprint $table) {
                $table->dropIndex(['jenis_pembayaran']);
                $table->dropColumn('jenis_pembayaran');
            });
        }
    }
};
