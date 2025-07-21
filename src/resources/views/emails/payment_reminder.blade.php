<!DOCTYPE html>
<html>
<head>
    <title>Pengingat Pembayaran</title>
</head>
<body>
    <h1>Halo, {{ $expense->user->name }}!</h1>
    <p>Ini adalah pengingat bahwa ada pengeluaran yang jatuh tempo hari ini:</p>

    <ul>
        <li><strong>Deskripsi:</strong> {{ $expense->description }}</li>
        <li><strong>Jumlah:</strong> Rp {{ number_format($expense->amount) }}</li>
        <li><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($expense->due_date)->format('d F Y') }}</li>
    </ul>

    <p>Mohon segera lakukan pembayaran. Terima kasih.</p>
</body>
</html>