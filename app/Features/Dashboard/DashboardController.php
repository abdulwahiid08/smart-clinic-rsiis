<?php

namespace App\Features\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Asesmen;
use App\Models\Kunjungan;
use App\Models\Pasien;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard.index', [
            'totalPasien' => Pasien::count(),
            'kunjunganHariIni' => Kunjungan::whereDate('tanggal_kunjungan', today())->count(),
            'asesmenHariIni' => Asesmen::whereHas('kunjungan', fn ($query) => $query->whereDate('tanggal_kunjungan', today()))->count(),
            'kunjunganBatal' => Kunjungan::where('status', Kunjungan::STATUS_BATAL)->count(),
            'kunjungans' => Kunjungan::with(['pasien', 'poli', 'dokter', 'asesmen'])->latest()->limit(6)->get(),
        ]);
    }
}
