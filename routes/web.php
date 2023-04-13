<?php

use App\Controllers\testController;
use Rahisi\Routes\Route;

Route::Get("", function ()
{
  view("index");
});

Route::Get("", [testController::class,"index"]);