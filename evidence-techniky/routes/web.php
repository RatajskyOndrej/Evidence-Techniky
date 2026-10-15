<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ServiceRecordController;

// Hlavní stránka přesměruje na seznam zařízení
Route::redirect('/', '/equipment');

// CRUD operace pro zařízení
Route::resource('equipment', EquipmentController::class);

// Uložení servisního zásahu ke konkrétnímu zařízení
Route::post('/equipment/{equipment}/service-records',
    [ServiceRecordController::class, 'store']
)->name('service-records.store');
