<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // app/Http/Controllers/TransactionController.php

    public function index(Request $request)
    {
        // Set default values for filters
        $isNegative = $request->input('debit', false);
        $isPositive = $request->input('credit', false);
        $minAmount = $request->input('min_amount', null);
        $maxAmount = $request->input('max_amount', null);
        $createdAt = $request->input('created_at', null);

        // Build the query based on filters
        $query = Transaction::query();

        if ($isNegative) {
            $query->where('amount', '<', 0);
        }

        if ($isPositive) {
            $query->where('amount', '>', 0);
        }

        if ($minAmount !== null) {
            $query->where('amount', '>=', $minAmount);
        }

        if ($maxAmount !== null) {
            $query->where('amount', '<=', $maxAmount);
        }

        if ($createdAt !== null) {
            $query->whereDate('created_at', $createdAt);
        }

        // Get the filtered list of transactions
        $transactions = $query->get();

        return response()->json($transactions);
    }

    public function store(Request $request)
    {
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
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction);
    }
}
