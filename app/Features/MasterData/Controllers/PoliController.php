<?php

namespace App\Features\MasterData\Controllers;

use App\Features\MasterData\Requests\StorePoliRequest;
use App\Features\MasterData\Requests\UpdatePoliRequest;
use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PoliController extends Controller
{
    public function index(): View
    {
        return view('master.polis.index', [
            'polis' => Poli::withCount(['dokters', 'kunjungans'])
                ->orderBy('nama_poli')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('master.polis.create', ['poli' => new Poli()]);
    }

    public function store(StorePoliRequest $request): RedirectResponse
    {
        DB::transaction(fn () => Poli::create($request->validated()));

        return redirect()
            ->route('master.polis.index')
            ->with('success', 'Poli berhasil ditambahkan.');
    }

    public function edit(Poli $poli): View
    {
        return view('master.polis.edit', compact('poli'));
    }

    public function update(UpdatePoliRequest $request, Poli $poli): RedirectResponse
    {
        DB::transaction(fn () => $poli->update($request->validated()));

        return redirect()
            ->route('master.polis.index')
            ->with('success', 'Poli berhasil diperbarui.');
    }

    public function destroy(Poli $poli): RedirectResponse
    {
        if ($poli->kunjungans()->exists() || $poli->dokters()->exists()) {
            throw ValidationException::withMessages([
                'poli' => 'Poli tidak dapat dihapus karena masih memiliki dokter atau kunjungan.',
            ]);
        }

        DB::transaction(fn () => $poli->delete());

        return redirect()
            ->route('master.polis.index')
            ->with('success', 'Poli berhasil dihapus.');
    }
}
