<?php

namespace App\Features\Laporan\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Kunjungan::query()
            ->with(['pasien', 'poli', 'dokter', 'asesmen'])
            ->when($request->filled('nama_pasien'), function ($query) use ($request) {
                $query->whereHas('pasien', fn ($pasien) => $pasien->where('nama_pasien', 'like', '%' . $request->nama_pasien . '%'));
            })
            ->when($request->filled('tanggal_kunjungan'), fn ($query) => $query->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan))
            ->when($request->filled('dokter_id'), fn ($query) => $query->where('dokter_id', $request->dokter_id))
            ->when($request->filled('diagnosis'), function ($query) use ($request) {
                $query->whereHas('asesmen', fn ($asesmen) => $asesmen->where('diagnosis_awal', 'like', '%' . $request->diagnosis . '%'));
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status));

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
}
