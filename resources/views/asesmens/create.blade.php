@extends('layouts.app')

@section('title', 'Asesmen Rawat Jalan')
@section('page-title', 'Asesmen Rawat Jalan')
@section('eyebrow', $kunjungan->kode_kunjungan)

@section('content')
    <form method="POST" action="{{ route('asesmens.store', $kunjungan) }}">
        @csrf
        @include('asesmens._form', ['asesmen' => null, 'submit' => 'Simpan Asesmen'])
    </form>
@endsection
