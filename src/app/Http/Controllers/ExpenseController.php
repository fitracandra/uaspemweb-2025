<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        // Ambil 5 data pengeluaran terbaru beserta kategorinya
        $latestExpenses = Expense::with('category')->latest()->take(5)->get();

        // Kirim data tersebut ke view 'welcome'
        return view('welcome', [
            'expenses' => $latestExpenses
        ]);
    }
}
