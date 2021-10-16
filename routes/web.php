<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\DB;
use App\Models\Scoreboard;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $data = DB::table('users')
        ->join('scoreboards', 'users.id', '=', 'scoreboards.user_id')
        ->selectRaw('sum(scoreboards.number_score) as sum, users.id')
        ->groupBy('users.id')
        ->orderBy('sum', 'desc')
        ->get();
    $all = Scoreboard::sum('number_score');

    //////////////////////////////////////////////////////////////////////////
    $user = DB::table('users')->get();
    $sum = '';
    $name = '';
    foreach ($data as $key => $value) {
        $sum .= '' . $value->sum . ',';
        foreach ($user as $key => $item) {
            if ($item->id == $value->id) {
                $name .= '' . "'" . $item->name . "'" . ',';
            }
        }
    }
    $arr['sum'] = rtrim($sum, ',');
    $arr['name'] = rtrim($name, ',');
    // print_r($arr);
    // dd($arr);
    return view('welcome', $arr, compact('all', 'data'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Google login
Route::get('login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

// Facebook login
Route::get('login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback']);

//create data in HomeController
Route::post('/create/data', [HomeController::class, 'create'])->name('create_data');
