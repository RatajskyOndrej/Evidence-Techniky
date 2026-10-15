<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;

// Po otevření hlavní stránky přejdeme na seznam zařízení
Route::redirect('/', '/equipment');

// Resource automaticky vytvoří routy pro CRUD
// Například index, create, store, edit, update a destroy
Route::resource('equipment', EquipmentController::class);
