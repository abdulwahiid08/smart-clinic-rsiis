<?php

namespace App\Features\MasterData\Controllers;

use App\Features\MasterData\Requests\StoreDokterRequest;
use App\Features\MasterData\Requests\UpdateDokterRequest;
use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Poli;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DokterController extends Controller
{
    public function index(): View
    {
        return view('master.dokters.index', [
            'dokters' => Dokter::with('poli')
                ->withCount('kunjungans')
                ->orderBy('nama_dokter')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('master.dokters.create', [
            'dokter' => new Dokter(),
            'polis' => Poli::orderBy('nama_poli')->get(),
        ]);
    }

    public function store(StoreDokterRequest $request): RedirectResponse
    {
        DB::transaction(fn () => Dokter::create($request->validated()));

        return redirect()
            ->route('master.dokters.index')
            ->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function edit(Dokter $dokter): View
    {
        return view('master.dokters.edit', [
            'dokter' => $dokter,
            'polis' => Poli::orderBy('nama_poli')->get(),
        ]);
    }

    public function update(UpdateDokterRequest $request, Dokter $dokter): RedirectResponse
    {
        DB::transaction(fn () => $dokter->update($request->validated()));

        return redirect()
            ->route('master.dokters.index')
            ->with('success', 'Dokter berhasil diperbarui.');
    }

    public function destroy(Dokter $dokter): RedirectResponse
    {
        if ($dokter->kunjungans()->exists()) {
            throw ValidationException::withMessages([
                'dokter' => 'Dokter tidak dapat dihapus karena sudah memiliki kunjungan.',
            ]);
        }

        DB::transaction(fn () => $dokter->delete());

        return redirect()
            ->route('master.dokters.index')
            ->with('success', 'Dokter berhasil dihapus.');
    }
}
