<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ScanController;
use Illuminate\Support\Facades\Route;

Route::get('/customers', [CustomerController::class, 'index']);

Route::get('/', [ScanController::class, 'index'])->name('scan.index');
Route::post('/scan/run', [ScanController::class, 'runScan'])->name('scan.run');
Route::get('/scans', [ScanController::class, 'allScans'])->name('scan.list');
