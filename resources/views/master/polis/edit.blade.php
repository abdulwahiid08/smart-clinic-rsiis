@extends('layouts.app')

@section('title', 'Edit Poli')
@section('page-title', 'Edit Poli')
@section('eyebrow', $poli->nama_poli)

@section('content')
    <form method="POST" action="{{ route('master.polis.update', $poli) }}">
        @csrf
        @method('PUT')
        @include('master.polis._form', ['submit' => 'Perbarui Poli'])
    </form>
@endsection
