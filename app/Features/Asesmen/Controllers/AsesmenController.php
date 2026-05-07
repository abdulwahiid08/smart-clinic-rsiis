<?php

namespace App\Features\Asesmen\Controllers;

use App\Features\Asesmen\Requests\StoreAsesmenRequest;
use App\Features\Asesmen\Requests\UpdateAsesmenRequest;
use App\Features\Asesmen\Services\AsesmenService;
use App\Http\Controllers\Controller;
use App\Models\Asesmen;
use App\Models\Kunjungan;
use App\Models\Pasien;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AsesmenController extends Controller
{
    public function __construct(private readonly AsesmenService $asesmenService)
    {
    }

    public function create(Kunjungan $kunjungan): View
    {
        return view('asesmens.create', [
            'kunjungan' => $kunjungan->load(['pasien', 'poli', 'dokter', 'asesmen']),
        ]);
    }

    public function store(StoreAsesmenRequest $request, Kunjungan $kunjungan): RedirectResponse
    {
        $this->asesmenService->store($kunjungan, $request->validated());

        return redirect()
            ->route('kunjungans.show', $kunjungan)
            ->with('success', 'Asesmen rawat jalan berhasil disimpan.');
    }

    public function edit(Asesmen $asesmen): View
    {
        return view('asesmens.edit', [
            'asesmen' => $asesmen->load(['kunjungan.pasien', 'kunjungan.poli', 'kunjungan.dokter']),
        ]);
    }

    public function update(UpdateAsesmenRequest $request, Asesmen $asesmen): RedirectResponse
    {
        $asesmen = $this->asesmenService->update($asesmen, $request->validated());

        return redirect()
            ->route('kunjungans.show', $asesmen->kunjungan)
            ->with('success', 'Asesmen berhasil diperbarui.');
    }

    public function history(Pasien $pasien): View
    {
        return view('asesmens.history', [
            'pasien' => $pasien->load(['kunjungans' => fn ($query) => $query->with(['poli', 'dokter', 'asesmen'])->latest()]),
        ]);
    }
}
