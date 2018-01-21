<?php

namespace App\Http\Controllers;

use App\Queries\OptimisticLockingTransaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Add Depostit
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function deposit()
    {
        request()->validate(['deposit' => 'required|numeric']);

        try {
            $data = [
                'country_id' => 1,
                'amount' => request()->get('deposit'),
                'type' => request()->get('type')
            ];
            // We can make a service and inject(constructor or method injection) with repo as a dependency itself
            (new OptimisticLockingTransaction(auth()->id(), $data))->update();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['deposit' => $e->getMessage()]);
        }

        return redirect()
            ->back()
            ->with('success', 'Your deposit request has been succesfully submitted.');
    }

    public function withdraw()
    {
        request()->validate(['withdraw' => 'required|numeric']);

        try {
            $data = [
                'country_id' => 1,
                'amount' => request()->get('withdraw'),
                'type' => request()->get('type')
            ];
            // We can make a service and inject(constructor or method injection) with repo as a dependency itself
            (new OptimisticLockingTransaction(auth()->id(), $data))->update();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['withdraw' => $e->getMessage()]);
        }

        return redirect()
            ->back()
            ->with('success', 'Your withdrawal request has been succesfully submitted.');
    }
}
