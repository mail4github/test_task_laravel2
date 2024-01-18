<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

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
		//echo '123'; exit;

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|integer',
        ]);

        // Add the authenticated user's ID to the transaction data
        $validatedData['author_id'] = Auth::id();

        // Create a new transaction record
        $transaction = Transaction::create($validatedData);

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
