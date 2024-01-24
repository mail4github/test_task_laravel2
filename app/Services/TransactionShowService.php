<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionShowService
{
	/**
     * Display the specified transaction.
	 *
	 * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showTransaction($id)
    {
		// Get a specific transaction record
        $transaction = Transaction::findOrFail($id);
        return $transaction;
    }
}