@extends('layouts.app')

@section('title', 'Daftar Kunjungan')
@section('page-title', 'Daftar Kunjungan')
@section('eyebrow', 'Pendaftaran Pasien')

@section('header-action')
    <a class="button primary" href="{{ route('kunjungans.create') }}">+ Daftar Pasien</a>
@endsection

@section('content')
    <section class="panel">
        <form class="filter-bar" method="GET">
            <input name="q" value="{{ request('q') }}" placeholder="Cari nama pasien atau kode kunjungan">
            <button class="button dark" type="submit">Cari</button>
            <a class="button ghost" href="{{ route('kunjungans.index') }}">Reset</a>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode</th>
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
                            <td>{{ $kunjungan->tanggal_kunjungan->format('d M Y') }}</td>
                            <td>{{ $kunjungan->kode_kunjungan }}</td>
                            <td>{{ $kunjungan->pasien->nama_pasien }}</td>
                            <td>{{ $kunjungan->poli->nama_poli }}</td>
                            <td>{{ $kunjungan->dokter->nama_dokter }}</td>
                            <td><span class="badge {{ $kunjungan->status }}">{{ str_replace('_', ' ', $kunjungan->status) }}</span></td>
                            <td class="actions">
                                <a href="{{ route('kunjungans.show', $kunjungan) }}">Detail</a>
                                <a href="{{ route('kunjungans.edit', $kunjungan) }}">Edit</a>
                                @if ($kunjungan->status === \App\Models\Kunjungan::STATUS_TERDAFTAR)
                                    <form method="POST" action="{{ route('kunjungans.cancel', $kunjungan) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit">Batal</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="empty">Data kunjungan belum tersedia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $kunjungans->links() }}
    </section>
@endsection
