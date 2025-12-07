<?php

use Illuminate\Support\Facades\Route;

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/profile', 'auth.profile')->name('profile');

// لوحة الزبون
Route::view('/customer', 'customer.dashboard')->name('customer.dashboard');

// لوحة مقدّم الخدمة
Route::view('/provider', 'provider.dashboard')->name('provider.dashboard');

Route::view('/', 'public.services')->name('public.services');

// صفحة تفاصيل خدمة معيّنة
Route::view('/service/{id}', 'public.service_show')->name('public.service.show');

// صفحة بروفايل مزوّد خدمة
Route::view('/provider/{id}', 'public.provider_show')->name('public.provider.show');

Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');
