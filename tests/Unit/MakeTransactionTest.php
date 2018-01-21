<?php

namespace Tests\Unit;

use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\InvalidAccountException;
use App\Services\BankAccountLocking;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MakeTransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws InvalidAccountException
     */
    public function test_submitted_amount_is_greater_than_available_balance()
    {
        $this->withExceptionHandling();

        $account = factory(User::class)->create([
            'balance' => 50,
        ]);

        auth()->loginUsingId($account->id);

        $requestDataArray = [
            'amount' => 100,
            'type' => 0
        ];

        try {
            app()->make(BankAccountLocking::class)->process($requestDataArray);
        } catch (InsufficientBalanceException $e) {
            $this->assertEquals($e->getMessage(), 'The submitted amount is greater than your available balance.');
        }
    }

    /**
     * @throws InsufficientBalanceException
     * @throws InvalidAccountException
     */
    public function test_add_deposit_ammount()
    {
        $this->withExceptionHandling();

        $account = factory(User::class)->create([
            'balance' => 50,
        ]);

        auth()->loginUsingId($account->id);

        $requestDataArray = [
            'amount' => 100,
            'type' => 1,
            'country_id' => 4
        ];

        app()->make(BankAccountLocking::class)->process($requestDataArray);

        $this->assertEquals($account->fresh()->balance, 150);
        $this->assertEquals($account->fresh()->count_transaction, 1);
    }

    /**
     * @throws InsufficientBalanceException
     * @throws InvalidAccountException
     */
    public function test_withdrawal_ammount()
    {
        $this->withExceptionHandling();

        $account = factory(User::class)->create([
            'balance' => 50,
        ]);

        auth()->loginUsingId($account->id);

        $requestDataArray = [
            'amount' => 25,
            'type' => 0,
            'country_id' => 4
        ];

        app()->make(BankAccountLocking::class)->process($requestDataArray);

        $this->assertEquals($account->fresh()->balance, 25);
        $this->assertEquals($account->fresh()->count_transaction, 0);
    }

    /**
     * @throws InsufficientBalanceException
     * @throws InvalidAccountException
     */
    public function test_increment_bonus()
    {
        $this->withExceptionHandling();

        $account = factory(User::class)->create([
            'balance' => 50,
            'count_transaction' => 2,
        ]);

        auth()->loginUsingId($account->id);

        $requestDataArray = [
            'amount' => 25,
            'type' => 1,
            'country_id' => 4
        ];

        $bankLocking = app()->make(BankAccountLocking::class);
        $bankLocking->process($requestDataArray);

        $bonusAdded = $bankLocking->inPercentages($account->bonus_param, $requestDataArray['amount']);

        $this->assertEquals($account->fresh()->balance, 75);
        $this->assertEquals($account->fresh()->count_transaction, 3);
        $this->assertEquals($account->fresh()->bonus, $account->bonus + $bonusAdded);
    }
}
