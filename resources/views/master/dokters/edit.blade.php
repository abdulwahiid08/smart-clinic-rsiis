@extends('layouts.app')

@section('title', 'Edit Dokter')
@section('page-title', 'Edit Dokter')
@section('eyebrow', $dokter->nama_dokter)

@section('content')
    <form method="POST" action="{{ route('master.dokters.update', $dokter) }}">
        @csrf
        @method('PUT')
        @include('master.dokters._form', ['submit' => 'Perbarui Dokter'])
    </form>
@endsection
