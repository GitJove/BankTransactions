<?php

namespace App\Repositories\Eloquent\Transaction;

use App\Repositories\Eloquent\RepositoryInterface;

/**
 * Laravel 5 Repositories is used to abstract the data layer, making our application more flexible to maintain.
 *
 * The TransactionRepositoryInterface contains ONLY method signatures for methods 
 * related to the User object.
 *
 * Note that we extend from RepositoryInterface, so any class that implements 
 * this interface must also provide all the standard eloquent methods (find, all, etc.)
 *
 * I usually use something more complex(package) : https://github.com/andersao/l5-repository
 */
interface TransactionRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Transaction Collection instance
     */
    public function getFrom($dateTimeString);

    /**
     * @return Transaction Collection instance
     */
    public function saveTransaction($data);
}