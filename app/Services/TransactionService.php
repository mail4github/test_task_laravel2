<?php

namespace App\Services;

use App\Models\Transaction;

/**
 * Class TransactionService
 *
 * Service class for handling transaction-related database queries.
 *
 * @package App\Services
 */
class TransactionService
{
    /**
     * Get a list of transactions with optional filters.
     *
     * @param bool   $isNegative Whether to include transactions with negative amounts.
     * @param bool   $isPositive Whether to include transactions with positive amounts.
     * @param int|null $minAmount Minimum transaction amount filter.
     * @param int|null $maxAmount Maximum transaction amount filter.
     * @param string|null $createdAt Date filter for transactions created at a specific date (YYYY-MM-DD format).
     *
     * @return \Illuminate\Database\Eloquent\Collection|Transaction[] List of filtered transactions.
     */
    public function getFilteredTransactions($isNegative, $isPositive, $minAmount, $maxAmount, $createdAt)
    {
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

        return $query->get();
    }
}
