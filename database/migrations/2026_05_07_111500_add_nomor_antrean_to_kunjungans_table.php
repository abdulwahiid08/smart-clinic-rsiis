<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columnCreated = false;

        if (! Schema::hasColumn('kunjungans', 'nomor_antrean')) {
            Schema::table('kunjungans', function (Blueprint $table) {
                $table->unsignedInteger('nomor_antrean')->nullable()->after('tanggal_kunjungan');
            });

            $columnCreated = true;
        }

        $groups = DB::table('kunjungans')
            ->select('tanggal_kunjungan', 'poli_id')
            ->groupBy('tanggal_kunjungan', 'poli_id')
            ->get();

        foreach ($groups as $group) {
            $kunjungans = DB::table('kunjungans')
                ->where('tanggal_kunjungan', $group->tanggal_kunjungan)
                ->where('poli_id', $group->poli_id)
                ->orderBy('created_at')
                ->orderBy('id')
                ->get(['id']);

            foreach ($kunjungans as $index => $kunjungan) {
                DB::table('kunjungans')
                    ->where('id', $kunjungan->id)
                    ->update(['nomor_antrean' => $index + 1]);
            }
        }

        if ($columnCreated) {
            Schema::table('kunjungans', function (Blueprint $table) {
                $table->index('nomor_antrean');
                $table->unique([
                    'tanggal_kunjungan',
                    'poli_id',
                    'nomor_antrean',
                ], 'kunjungans_tanggal_poli_nomor_unique');
            });
        }
    }

    public function down(): void
    {
        $hasMigrationIndex = collect(DB::select("SHOW INDEX FROM kunjungans WHERE Key_name = 'kunjungans_tanggal_poli_nomor_unique'"))->isNotEmpty();

        if (Schema::hasColumn('kunjungans', 'nomor_antrean') && $hasMigrationIndex) {
            Schema::table('kunjungans', function (Blueprint $table) {
                $table->dropUnique('kunjungans_tanggal_poli_nomor_unique');
                $table->dropIndex(['nomor_antrean']);
                $table->dropColumn('nomor_antrean');
            });
        }
    }
};
