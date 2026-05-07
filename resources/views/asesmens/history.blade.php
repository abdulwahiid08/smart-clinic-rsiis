@extends('layouts.app')

@section('title', 'Riwayat Asesmen')
@section('page-title', 'Riwayat Asesmen')
@section('eyebrow', $pasien->nama_pasien)

@section('content')
    <section class="panel">
        <div class="timeline">
            @forelse ($pasien->kunjungans as $kunjungan)
                <article class="timeline-item">
                    <time>{{ $kunjungan->tanggal_kunjungan->format('d M Y') }}</time>
                    <div>
                        <h2>{{ $kunjungan->poli->nama_poli }} - {{ $kunjungan->dokter->nama_dokter }}</h2>
                        @if ($kunjungan->asesmen)
                            <p><strong>Keluhan:</strong> {{ $kunjungan->asesmen->keluhan_utama }}</p>
                            <p><strong>Diagnosis:</strong> {{ $kunjungan->asesmen->diagnosis_awal }}</p>
                        @else
                            <p>Belum ada asesmen.</p>
                        @endif
                    </div>
                </article>
            @empty
                <p class="empty">Belum ada riwayat kunjungan.</p>
            @endforelse
        </div>
    </section>
@endsection
