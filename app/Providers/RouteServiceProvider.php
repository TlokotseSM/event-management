<?php
use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->middleware('api')
    ->namespace($this->namespace)
    ->group(base_path('routes/api.php'));
