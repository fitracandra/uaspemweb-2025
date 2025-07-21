<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Http\Controllers\ExpenseDisplayController;
use App\Models\Expense;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExpenseNotificationMail;
use Illuminate\Support\Facades\Artisan;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});

/*
/ END
*/
Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [ExpenseDisplayController::class, 'index']);
Route::get('/semua-pengeluaran', [ExpenseDisplayController::class, 'showAll'])->name('expenses.all');
Route::post('/kirim-notifikasi', [ExpenseDisplayController::class, 'sendNotification'])->name('expenses.send_notification');

Route::get('/scheduler-trigger/Abc123Xyz789', function () {
    // Menjalankan perintah php artisan schedule:run
    Artisan::call('schedule:run');
    return "Scheduler executed!";
});
// Route::get('/test-email-gmail', function () {
//     $sampleExpense = Expense::first();

//     if ($sampleExpense) {
//         // Ganti dengan alamat email Anda untuk menerima tes
//         Mail::to('enterspace56@gmail.com')->send(new ExpenseNotificationMail($sampleExpense));
//         return "Email tes via SMTP Gmail telah dikirim!";
//     } else {
//         return "Tidak ada data pengeluaran untuk dikirim.";
//     }
// });