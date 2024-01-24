<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Events\TransactionCreated;
use App\Services\TransactionService;
use App\Http\Requests\TransactionRequest;
use App\Services\TransactionCreateService;
use App\Services\TransactionActionService;
use App\Services\TransactionDestroyService;
use App\Services\TransactionShowService;

/**
 * Class TransactionController
 *
 * @package App\Http\Controllers\TransactionController
 */

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions with optional filters.
     *
	 * @LRDparam debit boolean
     * @LRDparam credit boolean
	 * @LRDparam min_amount integer
     * @LRDparam max_amount integer
	 * @LRDparam created_at string
	 *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

	private $transactionService;
	private $transactionCreateService;
    private $transactionActionService;
	private $transactionDestroyService;
	private $transactionShowService;

    public function __construct(
		TransactionService $transactionService, 
		TransactionCreateService $transactionCreateService, 
		TransactionActionService $transactionActionService, 
		TransactionDestroyService $transactionDestroyService,
		TransactionShowService $transactionShowService)
    {
        $this->transactionService = $transactionService;
		$this->transactionCreateService = $transactionCreateService;
        $this->transactionActionService = $transactionActionService;
		$this->transactionDestroyService = $transactionDestroyService;
		$this->transactionShowService = $transactionShowService;
    }
	
	/**
     * Get a list of transactions with optional filters.
     *
     * @param Request $request The HTTP request instance.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Set default values for filters
        $isNegative = $request->input('debit', false);
        $isPositive = $request->input('credit', false);
        $minAmount = $request->input('min_amount', null);
        $maxAmount = $request->input('max_amount', null);
        $createdAt = $request->input('created_at', null);

		// Get the filtered list of transactions using the TransactionService
        $transactions = $this->transactionService->getFilteredTransactions($isNegative, $isPositive, $minAmount, $maxAmount, $createdAt);

        return response()->json($transactions);
    }
	
	/**
     * Store a newly created transaction in the database.
     *
     * @param TransactionRequest $request The validated transaction request instance.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TransactionRequest $request)
    {
        // Create the transaction
        $transaction = $this->transactionCreateService->createTransaction($request->validated(), Auth::id());

        // Perform additional actions
        $this->transactionActionService->sendTransactionEmail($transaction);
        $this->transactionActionService->logTransactionEvent($transaction);
        $this->transactionActionService->broadcastTransactionEvent($transaction);

        return response()->json($transaction, 201);
    }
    
    /**
     * Remove the specified transaction from storage.
     *
	 * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Delete the transaction using the TransactionDestroyService class
        $this->transactionDestroyService->deleteTransaction($id);

        return response()->json(null, 204);
    }

    /**
     * Display the specified transaction.
	 *
	 * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Get a specific transaction record using the transactionShowService class
        $transaction = $this->transactionShowService->showTransaction($id);

        return response()->json($transaction);
    }
}
