<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionCreateService
{
	/**
     * Store a newly created transaction and send notifications.
     *
	 * @LRDparam title string|max:255
	 * @LRDparam amount integer
	 *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTransaction(array $validatedData, $authorId)
    {
        $validatedData['author_id'] = $authorId;
        return Transaction::create($validatedData);
    }
}
