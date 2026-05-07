@extends('layouts.app')

@section('title', 'Dashboard Rawat Jalan')
@section('page-title', 'Dashboard Rawat Jalan')
@section('eyebrow', 'Ringkasan Operasional')

@section('header-action')
    <a class="button primary" href="{{ route('kunjungans.create') }}">+ Daftar Pasien</a>
@endsection

@section('content')
    <section class="stats-grid">
        <div class="stat-card">
            <small>Total Pasien</small>
            <strong>{{ number_format($totalPasien) }}</strong>
        </div>
        <div class="stat-card accent">
            <small>Kunjungan Hari Ini</small>
            <strong>{{ number_format($kunjunganHariIni) }}</strong>
        </div>
        <div class="stat-card">
            <small>Asesmen Hari Ini</small>
            <strong>{{ number_format($asesmenHariIni) }}</strong>
        </div>
        <div class="stat-card muted">
            <small>Kunjungan Batal</small>
            <strong>{{ number_format($kunjunganBatal) }}</strong>
        </div>
    </section>

    <section class="panel">
        <div class="panel-head">
            <div>
                <h2>Kunjungan Terbaru</h2>
                <p>Daftar pasien yang baru terdaftar atau sudah selesai asesmen.</p>
            </div>
            <a class="button ghost" href="{{ route('kunjungans.index') }}">Lihat Semua</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Antrean</th>
                        <th>Pasien</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kunjungans as $kunjungan)
                        <tr>
                            <td>{{ $kunjungan->kode_kunjungan }}</td>
                            <td>A{{ str_pad((string) $kunjungan->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $kunjungan->pasien->nama_pasien }}</td>
                            <td>{{ $kunjungan->poli->nama_poli }}</td>
                            <td>{{ $kunjungan->dokter->nama_dokter }}</td>
                            <td><span class="badge {{ $kunjungan->status }}">{{ str_replace('_', ' ', $kunjungan->status) }}</span></td>
                            <td><a href="{{ route('kunjungans.show', $kunjungan) }}">Detail</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="empty">Belum ada kunjungan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
