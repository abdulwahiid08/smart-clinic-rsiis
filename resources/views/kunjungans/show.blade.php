@extends('layouts.app')

@section('title', 'Detail Kunjungan')
@section('page-title', $kunjungan->pasien->nama_pasien)
@section('eyebrow', $kunjungan->kode_kunjungan)

@section('header-action')
    <div class="header-actions">
        <a class="button ghost" href="{{ route('asesmens.history', $kunjungan->pasien) }}">Riwayat Asesmen</a>
        @if (!$kunjungan->asesmen && $kunjungan->status !== \App\Models\Kunjungan::STATUS_BATAL)
            <a class="button primary" href="{{ route('asesmens.create', $kunjungan) }}">+ Buat Asesmen</a>
        @endif
    </div>
@endsection

@section('content')
    <section class="detail-grid">
        <div class="panel">
            <div class="panel-head">
                <div>
                    <h2>Informasi Kunjungan</h2>
                    <p>{{ $kunjungan->tanggal_kunjungan->format('d M Y') }} - {{ strtoupper($kunjungan->jenis_pembayaran) }}</p>
                </div>
                <span class="badge {{ $kunjungan->status }}">{{ str_replace('_', ' ', $kunjungan->status) }}</span>
            </div>
            <dl class="info-list">
                <div><dt>Poli</dt><dd>{{ $kunjungan->poli->nama_poli }}</dd></div>
                <div><dt>Dokter</dt><dd>{{ $kunjungan->dokter->nama_dokter }}</dd></div>
                <div><dt>No HP</dt><dd>{{ $kunjungan->pasien->nomor_hp ?: '-' }}</dd></div>
                <div><dt>Alamat</dt><dd>{{ $kunjungan->pasien->alamat ?: '-' }}</dd></div>
            </dl>
        </div>

        <div class="panel">
            <div class="panel-head">
                <div>
                    <h2>Asesmen</h2>
                    <p>Ringkasan pemeriksaan rawat jalan.</p>
                </div>
                @if ($kunjungan->asesmen)
                    <a class="button ghost" href="{{ route('asesmens.edit', $kunjungan->asesmen) }}">Edit</a>
                @endif
            </div>
            @if ($kunjungan->asesmen)
                <dl class="info-list">
                    <div><dt>Keluhan</dt><dd>{{ $kunjungan->asesmen->keluhan_utama }}</dd></div>
                    <div><dt>Tekanan Darah</dt><dd>{{ $kunjungan->asesmen->tekanan_darah ?: '-' }}</dd></div>
                    <div><dt>Suhu / BB</dt><dd>{{ $kunjungan->asesmen->suhu_tubuh ?: '-' }} C / {{ $kunjungan->asesmen->berat_badan ?: '-' }} kg</dd></div>
                    <div><dt>Diagnosis Awal</dt><dd>{{ $kunjungan->asesmen->diagnosis_awal }}</dd></div>
                    <div><dt>Tindakan</dt><dd>{{ $kunjungan->asesmen->tindakan_terapi ?: '-' }}</dd></div>
                    <div><dt>Catatan</dt><dd>{{ $kunjungan->asesmen->catatan_dokter ?: '-' }}</dd></div>
                </dl>
            @else
                <p class="empty">Belum ada asesmen untuk kunjungan ini.</p>
            @endif
        </div>
    </section>
@endsection
