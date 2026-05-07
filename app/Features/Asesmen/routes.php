<?php

use App\Features\Asesmen\Controllers\AsesmenController;
use Illuminate\Support\Facades\Route;

Route::get('kunjungans/{kunjungan}/asesmens/create', [AsesmenController::class, 'create'])->name('asesmens.create');
Route::post('kunjungans/{kunjungan}/asesmens', [AsesmenController::class, 'store'])->name('asesmens.store');
Route::get('asesmens/{asesmen}/edit', [AsesmenController::class, 'edit'])->name('asesmens.edit');
Route::put('asesmens/{asesmen}', [AsesmenController::class, 'update'])->name('asesmens.update');
Route::get('pasiens/{pasien}/asesmens/history', [AsesmenController::class, 'history'])->name('asesmens.history');
