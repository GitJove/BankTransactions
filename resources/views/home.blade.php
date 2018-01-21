@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        
        <div class="panel-heading">Transactions</div>

            <div class="panel panel-default">

                <div class="panel-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="col-md-12">
                        <div class="col-md-6" style="padding-left: 0;">
                            <form method="post" action="{{route('deposit')}}">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail2">Deposit amount:</label>
                                    <input type="text" name="deposit" class="form-control" id="exampleInputEmail2" aria-describedby="emailHelp2" placeholder="Enter deposit amount">
                                    <input type="hidden" name="type" value="1" />
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    @if ($errors->has('deposit'))
                                        <small style="color:red;" id="emailHelp2" class="form-text text-muted">{{ $errors->first('deposit') }}</small>
                                    @endif
                                </div>
                            </form>
                        
                            <form method="post" action="{{route('withdraw')}}">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Withdraw amount:</label>
                                    <input type="text" name="withdraw" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter withdraw amount">
                                    <input type="hidden" name="type" value="0" />
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    @if ($errors->has('withdraw'))
                                        <small style="color:red;" id="emailHelp" class="form-text text-muted">{{ $errors->first('withdraw') }}</small>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <h3>Your current status (balance)</h3>
                        <hr style="border-top: 1px solid #d9d9d9;">
                        <p>Bonus parameter: <span>{{auth()->user()->bonus_param}}%</span></p>
                        <p>Bonus: <span>{{auth()->user()->bonus}}</span></p>
                        <p>Balance: <span>{{auth()->user()->balance}}</span></p>
                    </div>
                    
                    <a class="btn btn-primary" href="/reporting" style="float:right;">Report preview</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
