<?php

use App\Features\Kunjungan\Controllers\KunjunganController;
use Illuminate\Support\Facades\Route;

Route::resource('kunjungans', KunjunganController::class)
    ->except('destroy')
    ->parameters(['kunjungans' => 'kunjungan']);
Route::patch('kunjungans/{kunjungan}/cancel', [KunjunganController::class, 'cancel'])->name('kunjungans.cancel');
