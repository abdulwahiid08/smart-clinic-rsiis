@extends('layouts.app')

@section('title', 'Tambah Dokter')
@section('page-title', 'Tambah Dokter')
@section('eyebrow', 'Master Data')

@section('content')
    <form method="POST" action="{{ route('master.dokters.store') }}">
        @csrf
        @include('master.dokters._form', ['submit' => 'Simpan Dokter'])
    </form>
@endsection
