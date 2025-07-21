<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Expense;
use App\Mail\PaymentReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class SendPaymentReminders extends Command
{
    // Ubah signature dan deskripsi
    protected $signature = 'app:send-payment-notifications';
    protected $description = 'Kirim notifikasi untuk pembayaran yang sudah dijadwalkan tepat waktu';

    public function handle()
    {
        $this->info('Mulai memproses notifikasi pembayaran...');
    
        $dueExpenses = Expense::where('payment_schedule', '<=', Carbon::now())
                              ->whereNull('notification_sent_at')
                              ->get();
    
        if ($dueExpenses->isEmpty()) {
            $this->info('Tidak ada pembayaran yang perlu dinotifikasi saat ini.');
            return;
        }
    
        foreach ($dueExpenses as $expense) {
            // ## PERUBAHAN DI SINI ##
            // Langsung kirim email ke alamat yang Anda tentukan.
            Mail::to('enterspace56@gmail.com')->send(new PaymentReminderMail($expense));
    
            $expense->update(['notification_sent_at' => Carbon::now()]);
    
            $this->info("Notifikasi untuk '{$expense->description}' telah dikirim");
        }
    
        $this->info('Semua notifikasi berhasil diproses.');
    }
}