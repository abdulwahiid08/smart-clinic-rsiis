@extends('layouts.app')

@section('title', 'Edit Asesmen')
@section('page-title', 'Edit Asesmen')
@section('eyebrow', $asesmen->kunjungan->kode_kunjungan)

@section('content')
    <form method="POST" action="{{ route('asesmens.update', $asesmen) }}">
        @csrf
        @method('PUT')
        @include('asesmens._form', ['kunjungan' => $asesmen->kunjungan, 'submit' => 'Perbarui Asesmen'])
    </form>
@endsection
