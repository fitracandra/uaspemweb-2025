<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Expense;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ExpenseStats extends BaseWidget
{
    protected function getStats(): array
    {
        // Menghitung total pengeluaran hari ini
        $todayExpenses = Expense::whereDate('expense_date', Carbon::today())->sum('amount');

        // Menghitung total pengeluaran bulan ini
        $monthExpenses = Expense::whereMonth('expense_date', Carbon::now()->month)
            ->whereYear('expense_date', Carbon::now()->year)
            ->sum('amount');

        // Menghitung total pengeluaran keseluruhan
        $totalExpenses = Expense::sum('amount');
        return [
            Stat::make('Total Pengeluaran Hari Ini', 'Rp ' . number_format($todayExpenses, 2))
            ->description('Pengeluaran yang tercatat hari ini')
            ->color('success'),
        Stat::make('Total Pengeluaran Bulan Ini', 'Rp ' . number_format($monthExpenses, 2))
            ->description('Pengeluaran di bulan ' . Carbon::now()->format('F'))
            ->color('warning'),
        Stat::make('Total Semua Pengeluaran', 'Rp ' . number_format($totalExpenses, 2))
            ->description('Seluruh pengeluaran yang pernah dicatat')
            ->color('primary'),
        ];
    }
}
