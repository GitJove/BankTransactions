<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositFormRequest;
use App\Http\Requests\WithdrawalFormRequest;
use App\Services\BankAccountLocking;
use Illuminate\Http\Request;

class TransactionActivityController extends Controller
{
    /**
     * @var BankAccountLocking
     */
    private $bankLocking;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BankAccountLocking $bankLocking)
    {
        $this->middleware('auth');
        $this->bankLocking = $bankLocking;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('transactions');
    }

    /**
     * Your deposit request
     *
     * @param DepositFormRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function deposit(DepositFormRequest $request)
    {
        try {
            $requestDataArray = [
                'amount' => request()->get('deposit'),
                'type' => request()->get('type'),
                'country_id' => 1            ];

            $this->bankLocking->process($requestDataArray);
        } catch (\Exception $exception) {
            return $this->errorDepositDelegator($exception);
        }
        return $this->successDepositDelegator();
    }

    // This is controllers responsibility (request delegation)
    public function successDepositDelegator()
    {
        return redirect()
            ->back()
            ->with('success', 'Your deposit request has been succesfully submitted.');
    }

    public function errorDepositDelegator($exception)
    {
        return redirect()
                ->back()
                ->withInput()
                ->withErrors(['deposit' => $exception->getMessage()]);
    }

    /**
     * Your withdrawl request
     *
     * @param WithdrawalFormRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function withdraw(WithdrawalFormRequest $request)
    {
        try {
            $requestDataArray = [
                'amount' => request()->get('withdraw'),
                'type' => request()->get('type'),
                'country_id' => 1
            ];

            $this->bankLocking->process($requestDataArray);
        } catch (\Exception $exception) {
            return $this->errorWithdrawalDelegator($exception);
        }
        return $this->successWithdrawalDelegator();
    }

    // This is controllers responsibility (request delegation)
    public function successWithdrawalDelegator()
    {
        return redirect()
            ->back()
            ->with('success', 'Your withdrawal request has been succesfully submitted.');
    }

    public function errorWithdrawalDelegator($exception)
    {
        return redirect()
                ->back()
                ->withInput()
                ->withErrors(['withdraw' => $exception->getMessage()]);
    }
}
