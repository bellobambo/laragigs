<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing


// ALL Listing

Route::get('/', [ListingController::class, 'index']);


// Single Listing


// show create form

Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');




// Store Listing
Route::post('/listings', [ListingController::class , 'store'])->middleware('auth');


// Show Edit Form

Route::get('/listings/{listing}/edit' , [ListingController::class, 'edit'])->middleware('auth');


// Update Listing
Route::put('/listings/{listing}' , [ListingController::class, 'update'])->middleware('auth');


// DELETE Listing
Route::delete('/listings/{listing}' , [ListingController::class, 'destroy'])->middleware('auth');


Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');



// Single Listing
Route::get('/listings/{listing}', [ListingController::class , 'show']);


// Single Listing
Route::get('/register', [UserController::class , 'create']);


// Create New User

Route::post('/users', [UserController::class , 'store'])->middleware('guest');


// Logout User


Route::post('/logout', [UserController::class , 'logout'])->middleware('auth');



// Show Login Form

Route::get('/login', [UserController::class , 'login'])->name('login')->middleware('guest');


// Log In User

Route::post('/users/authenticate', [UserController::class, 'authenticate']);




