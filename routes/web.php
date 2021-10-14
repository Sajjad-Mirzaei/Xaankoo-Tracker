<?php

use Illuminate\Support\Facades\Route;

Route::view('reset_password','auth.resetpassword')->name('password.reset');

Route::view('/','emails.ResetPassword');
