<?php

namespace Tests\Feature;

use App\Services\BankAccountLocking;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UpdateUserInSameTimeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws \App\Exceptions\InsufficientBalanceException
     * @throws \App\Exceptions\InvalidAccountException
     * @throws \Exception
     */
    public function test_different_transaction_requests_are_made_at_the_same_moment()
    {
        $account = factory(User::class)->create();
        auth()->loginUsingId($account->id);

        $requestDataArrayOne = [
            'amount' => 30,
            'type' => 1,
            'country_id' => 4
        ];

        $requestDataArrayTwo = [
            'amount' => 50,
            'type' => 1,
            'country_id' => 4
        ];

        DB::beginTransaction();

        app()->make(BankAccountLocking::class)->process($requestDataArrayOne);
        app()->make(BankAccountLocking::class)->process($requestDataArrayTwo);

        DB::commit();

        $account = $account->fresh();

        $this->assertEquals($account->fresh()->balance, 80);
        $this->assertEquals($account->fresh()->count_transaction, 2);
    }
}
