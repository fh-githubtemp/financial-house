@extends('layouts.layout')
@section('content')
    <h1>Transaction Report</h1>
    <form method="get" action="{{route('report')}}">
        <div class="form-row">
            <div class="form-group col-lg-1">
                <label for="fromDate">From Date (YYYY-MM-DD)</label>
                <input type="text" class="form-control" id="fromDate" name="fromDate" placeholder="From Date" value="{{app('request')->input('fromDate', '2015-01-01')}}">
            </div>
            <div class="form-group col-lg-1">
                <label for="toDate">To Date (YYYY-MM-DD)</label>
                <input type="text" class="form-control" id="toDate" name="toDate" placeholder="To Date" value="{{app('request')->input('toDate', \Carbon\Carbon::now()->format('Y-m-d'))}}">
            </div>
            <div class="form-group col-lg-1">
                <label for="merchant">Merchant Id</label>
                <input type="text" class="form-control" id="merchant" name="merchant" placeholder="Merchant Id" value="{{app('request')->input('merchant')}}">
            </div>
            <div class="form-group col-lg-1">
                <label for="acquirer">Acquirer Id</label>
                <input type="text" class="form-control" id="acquirer" name="acquirer" placeholder="Acquirer Id" value="{{app('request')->input('acquirer')}}">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{route('report')}}" class="btn btn-danger">Reset</a>
        </div>
    </form>
    @if($errors->any())
        <ul>
            <li>{{$errors->first()}}</li>
        </ul>
    @else
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th scope="col">Currency</th>
                        <th scope="col">Count</th>
                        <th scope="col">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($response['payload']['response'] as $row)
                        <tr>
                            <td>{{$row['currency']}}</td>
                            <td>{{$row['count']}}</td>
                            <td>{{$row['total']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
