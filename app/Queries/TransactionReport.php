<?php

namespace App\Queries;

use App\Transaction;

/**
 * Query Object usage:
 *
 * (new TransactionReport($weekly))->get();
 *
 * @return void
 */
class TransactionReport
{
    protected $scoped;

    public function __construct($scoped = null)
    {
        $this->scoped = $scoped ?: new Transaction;
    }

    public static function trigger($byCreatedAtTimestamp)
    {
        return $this->scoped
            ->select(
                [
                    \DB::raw("UPPER(( SELECT code FROM `countries`
                  WHERE `id` = country_id)) AS code"),
                    \DB::raw('COUNT(DISTINCT user_id) AS Unique_Customers'),
                    \DB::raw('COUNT(CASE WHEN type = 1 THEN id END) AS No_of_Deposits'),
                    \DB::raw('SUM(CASE WHEN type = 1 THEN amount END) AS deposit'),
                    \DB::raw('COUNT(CASE WHEN type = 0 THEN id END) AS No_of_withdraw'),
                    \DB::raw('SUM(CASE WHEN type = 0 THEN amount END) AS withdraw'),
                ]
            )
            ->where('created_at', '>', $byCreatedAtTimestamp)
            ->groupBy('country_id')
            ->paginate(5);
    }
}
