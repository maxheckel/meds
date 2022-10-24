<?php

use App\Http\Controllers\DosageController;
use App\Http\Controllers\MedsController;
use App\Models\Dosage;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    if (Auth::check()){
        return redirect('/dashboard');
    }
    return Inertia::render('Auth/Login', [
        'canResetPassword' => Route::has('login'),
    ]);
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {


        $dosages = Dosage::where('user_id', Auth::id())->with([
            'medication',
            'takes' => function($q) {
                $q->whereDate('taken_at', '>=', Carbon::now(Auth::user()->timezone)->startOfDay()->tz('UTC') )->whereDate('taken_at', '<=', Carbon::now(Auth::user()->timezone)->endOfDay()->tz('UTC') );
            }
        ])->whereDate('start', '<=', Carbon::now(Auth::user()->timezone)->format('Y-m-d'))->where(function($q){
            $q->whereDate('end', '>', Carbon::now(Auth::user()->timezone)->format('Y-m-d'))->orWhereNull('end');
        })->get();

        return Inertia::render('Dashboard', [
            'dosages' => $dosages
        ]);
    })->name('dashboard');

    Route::resource('meds', MedsController::class);
    Route::resource('dosage', DosageController::class);
    Route::post('/doeses/{id}/take', [DosageController::class, 'takeDose'])->name('doses.take');
    Route::delete('/takes/{id}', [DosageController::class, 'untakeDose'])->name('doses.untake');
});
