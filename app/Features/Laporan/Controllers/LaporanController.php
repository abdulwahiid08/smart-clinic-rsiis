<?php

namespace App\Features\Laporan\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $query = $this->reportQuery($request);

        $total = (clone $query)->count();
        $statusSummary = (clone $query)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $kunjungans = $query
            ->latest('tanggal_kunjungan')
            ->paginate(12)
            ->withQueryString();

        return view('laporans.index', [
            'kunjungans' => $kunjungans,
            'dokters' => Dokter::orderBy('nama_dokter')->get(),
            'total' => $total,
            'statusSummary' => $statusSummary,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $fileName = 'laporan-kunjungan-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($request) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Tanggal Kunjungan',
                'Nomor Antrean',
                'Kode Kunjungan',
                'Nama Pasien',
                'Poli',
                'Dokter',
                'Jenis Pembayaran',
                'Diagnosis Awal',
                'Status',
            ]);

            $this->reportQuery($request)
                ->orderBy('tanggal_kunjungan')
                ->orderBy('nomor_antrean')
                ->chunk(200, function ($kunjungans) use ($handle) {
                    foreach ($kunjungans as $kunjungan) {
                        fputcsv($handle, [
                            $kunjungan->tanggal_kunjungan->format('Y-m-d'),
                            'A' . str_pad((string) $kunjungan->nomor_antrean, 3, '0', STR_PAD_LEFT),
                            $kunjungan->kode_kunjungan,
                            $kunjungan->pasien->nama_pasien,
                            $kunjungan->poli->nama_poli,
                            $kunjungan->dokter->nama_dokter,
                            strtoupper($kunjungan->jenis_pembayaran),
                            $kunjungan->asesmen->diagnosis_awal ?? '-',
                            str_replace('_', ' ', $kunjungan->status),
                        ]);
                    }
                });

            fclose($handle);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }

    private function reportQuery(Request $request)
    {
        return Kunjungan::query()
            ->with(['pasien', 'poli', 'dokter', 'asesmen'])
            ->filterLaporan($request->only([
                'nama_pasien',
                'tanggal_kunjungan',
                'dokter_id',
                'diagnosis',
                'status',
            ]));
    }
}
