<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/clients', [ClientController::class, 'liste_client']);
Route::post('/clients', [ClientController::class, 'ajouter_client_traitement']);
