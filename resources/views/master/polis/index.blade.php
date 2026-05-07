@extends('layouts.app')

@section('title', 'Master Poli')
@section('page-title', 'Master Poli')
@section('eyebrow', 'Data Referensi')

@section('header-action')
    <div class="header-actions">
        <a class="button ghost" href="{{ route('master.dokters.index') }}">Dokter</a>
        <a class="button primary" href="{{ route('master.polis.create') }}">+ Tambah Poli</a>
    </div>
@endsection

@section('content')
    <section class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Poli</th>
                        <th>Deskripsi</th>
                        <th>Dokter</th>
                        <th>Kunjungan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($polis as $poli)
                        <tr>
                            <td>{{ $poli->nama_poli }}</td>
                            <td>{{ $poli->deskripsi ?: '-' }}</td>
                            <td>{{ $poli->dokters_count }}</td>
                            <td>{{ $poli->kunjungans_count }}</td>
                            <td class="actions">
                                <a href="{{ route('master.polis.edit', $poli) }}">Edit</a>
                                <form method="POST" action="{{ route('master.polis.destroy', $poli) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty">Belum ada data poli.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $polis->links() }}
    </section>
@endsection
