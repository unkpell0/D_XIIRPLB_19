@extends('layouts.admin')

@section('title', 'History | Admin')

@section('content')
<div class="container mx-auto mb-10 px-4 lg:px-0">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">History Login, Register, dan Transaksi</h2>

    @if ($users->count() > 0)
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Registrasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">History Transaksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $user->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                @if ($user->rental->count() > 0)
                                    <ul class="list-disc pl-5">
                                        @foreach ($user->rental as $rental)
                                            <li class="mb-2">
                                                <strong>Tanggal:</strong> {{ $rental->start_date->format('d M Y') }}<br>
                                                <strong>Mobil:</strong> {{ $rental->car->nama }}<br>
                                                <strong>Total:</strong> Rp{{ number_format($rental->total_payment, 0, ',', '.') }}<br>
                                                <a href="{{ route('rental.receipt', ['rentalId' => $rental->id]) }}" class="text-blue-500 hover:underline">Lihat Struk</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-gray-500">Tidak ada transaksi</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-700 mt-6">Belum ada pengguna yang terdaftar atau melakukan transaksi.</p>
    @endif
</div>
@endsection
