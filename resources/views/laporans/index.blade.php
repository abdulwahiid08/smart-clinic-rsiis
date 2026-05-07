@extends('layouts.app')

@section('title', 'Laporan Kunjungan')
@section('page-title', 'Laporan Kunjungan')
@section('eyebrow', 'Data dan Ringkasan')

@section('content')
    <section class="panel">
        <div class="panel-head">
            <div>
                <h2>Filter Laporan</h2>
                <p>Export akan mengikuti filter yang sedang dipakai.</p>
            </div>
            <a class="button ghost" href="{{ route('laporans.export', request()->query()) }}">Export CSV</a>
        </div>
        <form class="report-filter" method="GET">
            <label>Nama Pasien
                <input name="nama_pasien" value="{{ request('nama_pasien') }}" placeholder="Contoh: Ahmad">
            </label>
            <label>Tanggal
                <input type="date" name="tanggal_kunjungan" value="{{ request('tanggal_kunjungan') }}">
            </label>
            <label>Dokter
                <select name="dokter_id">
                    <option value="">Semua dokter</option>
                    @foreach ($dokters as $dokter)
                        <option value="{{ $dokter->id }}" @selected(request('dokter_id') === $dokter->id)>{{ $dokter->nama_dokter }}</option>
                    @endforeach
                </select>
            </label>
            <label>Diagnosa
                <input name="diagnosis" value="{{ request('diagnosis') }}" placeholder="Cari diagnosis">
            </label>
            <label>Status
                <select name="status">
                    <option value="">Semua status</option>
                    @foreach (['terdaftar' => 'Terdaftar', 'sudah_asesmen' => 'Sudah asesmen', 'batal' => 'Batal'] as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <div class="filter-actions">
                <button class="button dark" type="submit">Terapkan</button>
                <a class="button ghost" href="{{ route('laporans.index') }}">Reset</a>
            </div>
        </form>
    </section>

    <section class="stats-grid compact">
        <div class="stat-card accent"><small>Total Kunjungan</small><strong>{{ number_format($total) }}</strong></div>
        <div class="stat-card"><small>Terdaftar</small><strong>{{ number_format($statusSummary['terdaftar'] ?? 0) }}</strong></div>
        <div class="stat-card"><small>Sudah Asesmen</small><strong>{{ number_format($statusSummary['sudah_asesmen'] ?? 0) }}</strong></div>
        <div class="stat-card muted"><small>Batal</small><strong>{{ number_format($statusSummary['batal'] ?? 0) }}</strong></div>
    </section>

    <section class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal Kunjungan</th>
                        <th>Nama Pasien</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                        <th>Diagnosis Awal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kunjungans as $kunjungan)
                        <tr>
                            <td>{{ $kunjungan->tanggal_kunjungan->format('d M Y') }}</td>
                            <td>{{ $kunjungan->pasien->nama_pasien }}</td>
                            <td>{{ $kunjungan->poli->nama_poli }}</td>
                            <td>{{ $kunjungan->dokter->nama_dokter }}</td>
                            <td>{{ $kunjungan->asesmen->diagnosis_awal ?? '-' }}</td>
                            <td><span class="badge {{ $kunjungan->status }}">{{ str_replace('_', ' ', $kunjungan->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="empty">Tidak ada data sesuai filter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $kunjungans->links() }}
    </section>
@endsection
