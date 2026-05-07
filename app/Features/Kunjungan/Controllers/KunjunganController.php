<?php

namespace App\Features\Kunjungan\Controllers;

use App\Features\Kunjungan\Requests\StoreKunjunganRequest;
use App\Features\Kunjungan\Requests\UpdateKunjunganRequest;
use App\Features\Kunjungan\Services\PendaftaranService;
use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KunjunganController extends Controller
{
    public function __construct(private readonly PendaftaranService $pendaftaranService)
    {
    }

    public function index(Request $request): View
    {
        $kunjungans = Kunjungan::query()
            ->with(['pasien', 'poli', 'dokter', 'asesmen'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->whereHas('pasien', fn ($pasien) => $pasien->where('nama_pasien', 'like', '%' . $request->q . '%'))
                    ->orWhere('kode_kunjungan', 'like', '%' . $request->q . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('kunjungans.index', compact('kunjungans'));
    }

    public function create(): View
    {
        return view('kunjungans.create', [
            'polis' => Poli::orderBy('nama_poli')->get(),
            'dokters' => Dokter::with('poli')->orderBy('nama_dokter')->get(),
            'pasiens' => Pasien::orderBy('nama_pasien')->limit(200)->get(),
        ]);
    }

    public function store(StoreKunjunganRequest $request): RedirectResponse
    {
        $kunjungan = $this->pendaftaranService->store($request->validated());

        return redirect()
            ->route('kunjungans.show', $kunjungan)
            ->with('success', 'Pendaftaran pasien berhasil disimpan.');
    }

    public function show(Kunjungan $kunjungan): View
    {
        return view('kunjungans.show', [
            'kunjungan' => $kunjungan->load(['pasien.kunjungans.asesmen', 'poli', 'dokter', 'asesmen']),
        ]);
    }

    public function edit(Kunjungan $kunjungan): View
    {
        return view('kunjungans.edit', [
            'kunjungan' => $kunjungan->load(['pasien', 'poli', 'dokter']),
            'polis' => Poli::orderBy('nama_poli')->get(),
            'dokters' => Dokter::with('poli')->orderBy('nama_dokter')->get(),
        ]);
    }

    public function update(UpdateKunjunganRequest $request, Kunjungan $kunjungan): RedirectResponse
    {
        $kunjungan = $this->pendaftaranService->update($kunjungan->load('pasien'), $request->validated());

        return redirect()
            ->route('kunjungans.show', $kunjungan)
            ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    public function cancel(Kunjungan $kunjungan): RedirectResponse
    {
        $this->pendaftaranService->cancel($kunjungan);

        return redirect()
            ->route('kunjungans.index')
            ->with('success', 'Kunjungan berhasil dibatalkan.');
    }
}
