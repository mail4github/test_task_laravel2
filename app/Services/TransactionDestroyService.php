<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionDestroyService
{
	/**
     * Remove the specified transaction from storage.
     *
	 * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTransaction($id)
    {
		// Delete a transaction record
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
    }
}