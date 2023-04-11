<?php

use App\Controllers\testController;
use Rahisi\Routes\Route;

Route::Get("", [testController::class,'index']);
Route::Post("newTest", [testController::class,'store']);
Route::Get("putTest", [testController::class,'put']);
Route::Get("deleteTest", [testController::class,'delete']);