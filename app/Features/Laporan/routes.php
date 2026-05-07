<?php

use App\Features\Laporan\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('laporan', [LaporanController::class, 'index'])->name('laporans.index');
