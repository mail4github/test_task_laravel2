<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        // Get a list of transactions
        $transactions = Transaction::with('author')->get();
        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        // Add a new transaction record
        $transaction = Transaction::create($request->all());
        return response()->json($transaction, 201);
    }

    public function destroy($id)
    {
        // Delete a transaction record
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response()->json(null, 204);
    }

	public function show($id)
    {
        // Get a specific transaction record
        $transaction = Transaction::with('author')->findOrFail($id);
        return response()->json($transaction);
    }
}
