<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Recent Transactions</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">User</th>
                                    <th class="px-4 py-2">Type</th>
                                    <th class="px-4 py-2">Amount</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td class="border px-4 py-2">{{ $transaction->user->name }}</td>
                                    <td class="border px-4 py-2">{{ $transaction->type }}</td>
                                    <td class="border px-4 py-2">${{ number_format($transaction->amount, 2) }}</td>
                                    <td class="border px-4 py-2">
                                        <span class="px-2 py-1 rounded text-sm
                                            @if($transaction->status === 'success') bg-green-100 text-green-800
                                            @elseif($transaction->status === 'failed') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td class="border px-4 py-2">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('transactions.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            View All Transactions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 