<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/current-matches', function () {
    return view('liveMatches');
});

Route::get('/match-details/{matchId}', function ($matchId) {
    return view('matchDetails', compact('matchId'));
});
