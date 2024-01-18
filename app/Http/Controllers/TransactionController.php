<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Events\TransactionCreated;

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
		
		try {
			// Send email
			$this->sendTransactionEmail($transaction);
		}
		catch (Exception $e) {}

        // Log the event
        $this->logTransactionEvent($transaction);

		// Broadcast an event to the frontend
        broadcast(new TransactionCreated($transaction))->toOthers();

        return response()->json($transaction, 201);
    }

	private function sendTransactionEmail(Transaction $transaction)
    {
        $recipientEmail = 'example@example.com';
        $emailContent = "New transaction added:\nTitle: {$transaction->title}\nAmount: {$transaction->amount}";

        Mail::raw($emailContent, function ($message) use ($recipientEmail) {
            $message->to($recipientEmail)
                    ->subject('New Transaction Added');
        });
    }

    private function logTransactionEvent(Transaction $transaction)
    {
        // Log the event using the Laravel logger
        Log::info("New transaction added - Title: {$transaction->title}, Amount: {$transaction->amount}");
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
