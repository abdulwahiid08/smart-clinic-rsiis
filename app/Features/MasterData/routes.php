<?php

use App\Features\MasterData\Controllers\DokterController;
use App\Features\MasterData\Controllers\PoliController;
use Illuminate\Support\Facades\Route;

Route::prefix('master')->name('master.')->group(function () {
    Route::resource('polis', PoliController::class)->except('show')->parameters([
        'polis' => 'poli',
    ]);
    Route::resource('dokters', DokterController::class)->except('show')->parameters([
        'dokters' => 'dokter',
    ]);
});
