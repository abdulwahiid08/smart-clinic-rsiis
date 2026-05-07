@extends('layouts.app')

@section('title', 'Edit Pendaftaran')
@section('page-title', 'Edit Pendaftaran')
@section('eyebrow', $kunjungan->kode_kunjungan)

@section('content')
    <form method="POST" action="{{ route('kunjungans.update', $kunjungan) }}">
        @csrf
        @method('PUT')
        @include('kunjungans._form', ['submit' => 'Perbarui Data'])
    </form>
@endsection
