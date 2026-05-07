@extends('layouts.app')

@section('title', 'Master Dokter')
@section('page-title', 'Master Dokter')
@section('eyebrow', 'Data Referensi')

@section('header-action')
    <div class="header-actions">
        <a class="button ghost" href="{{ route('master.polis.index') }}">Poli</a>
        <a class="button primary" href="{{ route('master.dokters.create') }}">+ Tambah Dokter</a>
    </div>
@endsection

@section('content')
    <section class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Dokter</th>
                        <th>Spesialis</th>
                        <th>Poli</th>
                        <th>Kunjungan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dokters as $dokter)
                        <tr>
                            <td>{{ $dokter->nama_dokter }}</td>
                            <td>{{ $dokter->spesialis ?: '-' }}</td>
                            <td>{{ $dokter->poli->nama_poli }}</td>
                            <td>{{ $dokter->kunjungans_count }}</td>
                            <td class="actions">
                                <a href="{{ route('master.dokters.edit', $dokter) }}">Edit</a>
                                <form method="POST" action="{{ route('master.dokters.destroy', $dokter) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty">Belum ada data dokter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $dokters->links() }}
    </section>
@endsection
