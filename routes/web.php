<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\KlaviyoEventController;

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
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/contacts/import', [ContactController::class, 'import'])
    ->middleware(['auth'])->name('contacts.import');
Route::post('/contacts/import', [ContactController::class, 'parseImportFile'])
    ->middleware(['auth'])->name('contacts.parse_import');

Route::resource('contacts', ContactController::class)->middleware(['auth']);

Route::post('/track-event', [KlaviyoEventController::class, 'track'])
    ->middleware(['auth'])->name('events.track');

require __DIR__.'/auth.php';
