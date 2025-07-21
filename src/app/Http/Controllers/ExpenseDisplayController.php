<?php

namespace App\Http\Controllers;

use App\Mail\ExpenseNotificationMail;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // Import Carbon untuk manipulasi tanggal
use Illuminate\Support\Facades\Mail;

class ExpenseDisplayController extends Controller
{
    public function index()
    {
        // ... (Logika statistik kartu yang sudah ada)
        $latestExpenses = Expense::with('category')->latest()->take(5)->get();
        $todayExpenses = Expense::whereDate('expense_date', Carbon::today())->sum('amount');
        $monthExpenses = Expense::whereMonth('expense_date', Carbon::now()->month)
            ->whereYear('expense_date', Carbon::now()->year)
            ->sum('amount');
        $totalExpenses = Expense::sum('amount');

        // --- LOGIKA BARU UNTUK GRAFIK ---
        $monthlyExpenses = Expense::select(
            DB::raw("MONTHNAME(expense_date) as month_name"),
            DB::raw("SUM(amount) as total_amount")
        )
        ->whereYear('expense_date', date('Y'))
        ->groupBy('month_name')
        ->orderBy(DB::raw('MIN(expense_date)'), 'asc')
        ->get();

        $chartLabels = $monthlyExpenses->pluck('month_name');
        $chartData = $monthlyExpenses->pluck('total_amount');
        // --- AKHIR LOGIKA BARU ---

        // Kirim semua data ke view, termasuk data untuk grafik
        return view('welcome', [
            'expenses'      => $latestExpenses,
            'todayExpenses' => $todayExpenses,
            'monthExpenses' => $monthExpenses,
            'totalExpenses' => $totalExpenses,
            'chartLabels'   => $chartLabels, // <-- DATA BARU
            'chartData'     => $chartData,     // <-- DATA BARU
        ]);
    }
    public function showAll()
    {
        // ... method showAll tidak perlu diubah
        $allExpenses = Expense::with('category')->latest()->paginate(10);
        return view('expenses.all', [
            'expenses' => $allExpenses
        ]);
    }
    // METHOD BARU UNTUK MENGIRIM NOTIFIKASI
    public function sendNotification(Request $request)
    {
        // 1. Validasi input, pastikan yang dimasukkan adalah email yang valid
        $request->validate([
            'email' => 'required|email',
        ]);

        // 2. Ambil satu data pengeluaran terakhir sebagai contoh
        $latestExpense = Expense::latest()->first();

        // Jika tidak ada data, kembalikan dengan pesan error
        if (!$latestExpense) {
            return back()->with('status', 'Gagal: Tidak ada data pengeluaran untuk dikirim.');
        }

        // 3. Kirim email ke alamat yang diinput dari form
        Mail::to($request->email)->send(new ExpenseNotificationMail($latestExpense));

        // 4. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('status', 'Notifikasi berhasil dikirim ke ' . $request->email);
    }
}