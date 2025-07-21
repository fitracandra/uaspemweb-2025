<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Pengeluaran Baru</title>
</head>
<body>
    <h1>Halo!</h1>
    <p>Sebuah pengeluaran baru telah dicatat:</p>

    <ul>
        <li><strong>Deskripsi:</strong> {{ $expense->description }}</li>
        <li><strong>Jumlah:</strong> Rp {{ number_format($expense->amount) }}</li>
        <li><strong>Kategori:</strong> {{ $expense->category->name }}</li>
    </ul>

    <p>Terima kasih telah menggunakan aplikasi kami.</p>
</body>
</html>