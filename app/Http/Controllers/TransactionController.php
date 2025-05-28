<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $query = Transaction::with('user');
            
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
            
            $transactions = $query->latest()->paginate(15);
            return view('transactions.admin-index', compact('transactions'));
        }

        $transactions = $user->transactions()->latest()->paginate(15);
        return view('transactions.client-index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $transaction = auth()->user()->transactions()->create([
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'status' => 'pending',
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }
}
