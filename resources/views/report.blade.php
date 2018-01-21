@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        
                <div class="panel-heading">Transactions
                    <a class="btn btn-primary" href="{{route('transactions')}}" style="float:right;">Go Back</a>
                </div>
                
                <div class="panel-body">

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                        <table class="table table-bordered" style="text-align: center">
                            <thead>
                                <tr>
                                    <th width="100px">Date</th>
                                    <th>Country</th>
                                    <th>Unique Customers</th>
                                    <th>No of Deposits</th>
                                    <th>Total Deposit Amount</th>
                                    <th>No of Withdrawals</th>
                                    <th>Total Withdrawal Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($reports as $report)
                                    <tr>
                                        <td>{{$reports->date}}</td>
                                        <td>{{$report->country}}</td>
                                        <td>{{$report->unique_customers}}</td>
                                        <td>{{$report->no_of_deposits}}</td>
                                        <td>{{$report->total_deposit_amount}}</td>
                                        <td>{{$report->no_of_withdrawals}}</td>
                                        <td>-{{$report->total_withdrawal_amount}}</td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                </div>
        </div>
    </div>
</div>
@endsection
