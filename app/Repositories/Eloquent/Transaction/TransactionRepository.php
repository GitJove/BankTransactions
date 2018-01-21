<?php

namespace App\Repositories\Eloquent\Transaction;

use App;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\Transaction\TransactionRepositoryInterface;
use App\Transaction;

/**
 * Laravel 5 Repositories is used to abstract the data layer, making our application more flexible to maintain.
 *
 * The Abstract Repository provides default implementations of the methods defined
 * in the base repository interface. These simply delegate static function calls 
 * to the right eloquent model based on the $modelClassName.
 *  
 * I usually use something more complex(package) : https://github.com/andersao/l5-repository
 *
 */
class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    private $transaction;

    public function __construct(
        Transaction $transaction
    ) {
        $this->transaction = $transaction;
    }

    public function getFrom($dateTimeString)
    {
        return $this->transaction
               ->select(
                    [
                        \DB::raw("UPPER(( SELECT code FROM `countries`
                            WHERE `id` = country_id)) AS country"),
                        \DB::raw('COUNT(DISTINCT user_id) AS unique_customers'),
                        \DB::raw('COUNT(CASE WHEN type = 1 THEN id END) AS no_of_deposits'),
                        \DB::raw('SUM(CASE WHEN type = 1 THEN amount END) AS total_deposit_amount'),
                        \DB::raw('COUNT(CASE WHEN type = 0 THEN id END) AS no_of_withdrawals'),
                        \DB::raw('SUM(CASE WHEN type = 0 THEN amount END) AS total_withdrawal_amount'),
                    ]
                )
                ->where('created_at', '>', $dateTimeString)
                ->groupBy('country_id')
                ->get();
    }

    /**
     * @return Transaction Collection instance
     */
    public function saveTransaction($data)
    {
        $this->transaction->country_id = $data['country_id'];
        $this->transaction->user_id = auth()->id();
        $this->transaction->amount = $data['amount'];
        $this->transaction->type = $data['type'];

        $this->transaction->save();
    }
}
