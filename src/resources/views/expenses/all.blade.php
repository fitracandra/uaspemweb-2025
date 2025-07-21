@extends('layouts.frontend')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Semua Riwayat Pengeluaran</h1>
    <p class="mb-4">Berikut adalah seluruh data pengeluaran yang telah dicatat.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengeluaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->expense_date }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>{{ $expense->category->name }}</td>
                                <td>Rp {{ number_format($expense->amount) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- INI UNTUK MENAMPILKAN TOMBOL PAGINASI --}}
                <div class="mt-3">
                    {{ $expenses->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection