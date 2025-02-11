<?php

use App\Http\Controllers\LiveCricketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('cricket/live-matches', [LiveCricketController::class, 'getLiveMatches']);

Route::get('cricket/match-analysis/{matchId}', [LiveCricketController::class, 'getMatchAnalysis']);
Route::middleware(['auth:sanctum'])->group(function () {

});