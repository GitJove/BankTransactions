<?php

namespace App\Services;

use App\Repositories\Eloquent\Transaction\TransactionRepositoryInterface;
use App\Repositories\Eloquent\User\UserRepositoryInterface;
use App\Transaction;
use App\User;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\InvalidAccountException;

class BankAccountLocking
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    private $data;
    
    private $user;

    private $balance;

    /**
     * TransactionOperation constructor.
     * @param $transactionRepository
     * @param $data
     */
    public function __construct(
    	UserRepositoryInterface $userRepository,
    	TransactionRepositoryInterface $transactionRepository
	)
    {
        $this->userRepository = $userRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function withdraw(int $amount): void
    {
        if ($amount > $this->balance) {
            throw new \Exception('Amount is greater than available balance.');
        }

        $this->balance -= $amount;
    }

    public function deposit(int $amount): void
    {
        $this->balance += $amount;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @throws InvalidAccountException
     * @throws InsufficientBalanceException
     */
    public function process($requestDataArray)
    {
    	$this->data = $requestDataArray;

    	$account = $this->userRepository->userAcount();
    	$this->invalidAccountGuard($account);

        do {
            $this->user = $account->first();
            $this->insufficientBalanceGuard($this->data, $this->user);
            $this->depositOrWithdrawal($this->data['type']);

            $updatedAccount = $this->userRepository->updateAcount($this->userData);
        } while (! $updatedAccount);
        $this->transactionRepository->saveTransaction($this->data);
    }

    private function invalidAccountGuard($account)
    {
    	if (! $account->exists()) {
            throw new InvalidAccountException('User does not exist!');
        }
    }

    private function insufficientBalanceGuard($data, $user)
    {
    	if (!$data['type'] && $user->balance < $data['amount']) {
                throw new InsufficientBalanceException('The submitted amount is greater than your available balance.');
            }
    }

    private function depositOrWithdrawal($transactionType)
    {
        if ($transactionType) {
            $this->userData['balance'] = $this->user->balance + $this->data['amount'];
            $this->userData['count_transaction'] = ++$this->user->count_transaction;

            $this->thirdDepositCheck();
            return;
        }

        $this->userData['balance'] = $this->user->balance - $this->data['amount'];
    }

    private function thirdDepositCheck()
    {
        $awardedBonus = $this->userData['count_transaction'] / 3;

        if ((int) $awardedBonus === $awardedBonus) {
            $this->userData['bonus'] = $this->increaseBonus();
        }
    }

    private function increaseBonus()
    {
        return $this->user->bonus + $this->inPercentages($this->user->bonus_param, $this->data['amount']);
    }

    /**
     * @param $bonusParam
     * @param $amount
     * @return float|int
     */
    public function inPercentages($bonusParam, $amount)
    {
        return ($bonusParam / 100) * $amount;
    }
}
