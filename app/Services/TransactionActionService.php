<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Events\TransactionCreated;

class TransactionActionService
{
    /**
     * Send an email notification for the given transaction.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function sendTransactionEmail(Transaction $transaction)
    {
        $recipientEmail = 'example@example.com';
        $emailContent = "New transaction added:\nTitle: {$transaction->title}\nAmount: {$transaction->amount}";

        Mail::raw($emailContent, function ($message) use ($recipientEmail) {
            $message->to($recipientEmail)
                    ->subject('New Transaction Added');
        });
    }

    /**
     * Log the event of a new transaction.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function logTransactionEvent(Transaction $transaction)
    {
        // Log the event using the Laravel logger
        Log::info("New transaction added - Title: {$transaction->title}, Amount: {$transaction->amount}");
    }

	/**
     * Broadcast info about new transaction to the frontend.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function broadcastTransactionEvent(Transaction $transaction)
    {
        broadcast(new TransactionCreated($transaction))->toOthers();
    }
}
