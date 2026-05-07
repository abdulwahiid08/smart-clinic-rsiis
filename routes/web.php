<?php

use Illuminate\Support\Facades\Route;
use App\Features\Dashboard\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require app_path('Features/Auth/routes.php');

Route::middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    require app_path('Features/MasterData/routes.php');
    require app_path('Features/Kunjungan/routes.php');
    require app_path('Features/Asesmen/routes.php');
    require app_path('Features/Laporan/routes.php');
});
