@extends('layouts.app')

@section('title', 'Tambah Poli')
@section('page-title', 'Tambah Poli')
@section('eyebrow', 'Master Data')

@section('content')
    <form method="POST" action="{{ route('master.polis.store') }}">
        @csrf
        @include('master.polis._form', ['submit' => 'Simpan Poli'])
    </form>
@endsection
