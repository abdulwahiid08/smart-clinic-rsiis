@extends('layouts.app')

@section('title', 'Pendaftaran Pasien')
@section('page-title', 'Pendaftaran Pasien')
@section('eyebrow', 'Input Kunjungan Baru')

@section('content')
    <form method="POST" action="{{ route('kunjungans.store') }}">
        @csrf
        @include('kunjungans._form', ['kunjungan' => new \App\Models\Kunjungan(), 'submit' => 'Simpan Pendaftaran'])
    </form>
@endsection
