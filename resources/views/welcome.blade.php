@extends('layouts.layout')
@section('content')
    <h1>Transactions</h1>
    <form method="get" action="{{route('home')}}">
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
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option></option>
                    <option value="APPROVED" @if (app('request')->input('status') === 'APPROVED') selected @endif >APPROVED</option>
                    <option value="WAITING" @if (app('request')->input('status') === 'WAITING') selected @endif>WAITING</option>
                    <option value="DECLINED" @if (app('request')->input('status') === 'DECLINED') selected @endif>DECLINED</option>
                    <option value="ERROR" @if (app('request')->input('status') === 'ERROR') selected @endif>ERROR</option>
                </select>
            </div>
            <div class="form-group col-lg-1">
                <label for="operation">Operation</label>
                <select name="operation" id="operation" class="form-control">
                    <option></option>
                    <option value="DIRECT" @if (app('request')->input('operation') === 'DIRECT') selected @endif >DIRECT</option>
                    <option value="REFUND" @if (app('request')->input('operation') === 'REFUND') selected @endif>REFUND</option>
                    <option value="3D" @if (app('request')->input('operation') === '3D') selected @endif>3D</option>
                    <option value="3DAUTH" @if (app('request')->input('operation') === '3DAUTH') selected @endif>3DAUTH</option>
                    <option value="STORED" @if (app('request')->input('operation') === 'STORED') selected @endif>STORED</option>
                </select>
            </div>
            <div class="form-group col-lg-1">
                <label for="merchantId">Merchant Id</label>
                <input type="text" class="form-control" id="merchantId" name="merchantId" placeholder="Merchant Id" value="{{app('request')->input('merchantId')}}">
            </div>
            <div class="form-group col-lg-1">
                <label for="acquirerId">Acquirer Id</label>
                <input type="text" class="form-control" id="acquirerId" name="acquirerId" placeholder="Acquirer Id" value="{{app('request')->input('acquirerId')}}">
            </div>
            <div class="form-group col-lg-1">
                <label for="paymentMethod">Payment Method</label>
                <select name="paymentMethod" id="paymentMethod" class="form-control">
                    <option></option>
                    <option value="CREDITCARD" @if (app('request')->input('paymentMethod') === 'CREDITCARD') selected @endif >CREDITCARD</option>
                    <option value="CUP" @if (app('request')->input('paymentMethod') === 'CUP') selected @endif>CUP</option>
                    <option value="IDEAL" @if (app('request')->input('paymentMethod') === 'IDEAL') selected @endif>IDEAL</option>
                    <option value="GIROPAY" @if (app('request')->input('paymentMethod') === 'GIROPAY') selected @endif>GIROPAY</option>
                    <option value="MISTERCASH" @if (app('request')->input('paymentMethod') === 'MISTERCASH') selected @endif>MISTERCASH</option>
                    <option value="STORED" @if (app('request')->input('paymentMethod') === 'STORED') selected @endif>STORED</option>
                    <option value="PAYTOCARD" @if (app('request')->input('paymentMethod') === 'PAYTOCARD') selected @endif>PAYTOCARD</option>
                    <option value="CEPBANK" @if (app('request')->input('paymentMethod') === 'CEPBANK') selected @endif>CEPBANK</option>
                    <option value="CITADEL" @if (app('request')->input('paymentMethod') === 'CITADEL') selected @endif>CITADEL</option>
                </select>
            </div>
            <div class="form-group col-lg-1">
                <label for="errorCode">Error Code</label>
                <select name="errorCode" id="errorCode" class="form-control">
                    <option></option>
                    <option value="Do not honor" @if (app('request')->input('errorCode') === 'Do not honor') selected @endif >Do not honor</option>
                    <option value="Invalid Transaction" @if (app('request')->input('errorCode') === 'Invalid Transaction') selected @endif>Invalid Transaction</option>
                    <option value="Invalid Card" @if (app('request')->input('errorCode') === 'Invalid Card') selected @endif>Invalid Card</option>
                    <option value="Not sufficient funds" @if (app('request')->input('errorCode') === 'Not sufficient funds') selected @endif>Not sufficient funds</option>
                    <option value="Incorrect PIN" @if (app('request')->input('errorCode') === 'Incorrect PIN') selected @endif>Incorrect PIN</option>
                    <option value="Invalid country association" @if (app('request')->input('errorCode') === 'Invalid country association') selected @endif>Invalid country association</option>
                    <option value="Currency not allowed" @if (app('request')->input('errorCode') === 'Currency not allowed') selected @endif>Currency not allowed</option>
                    <option value="3-D Secure Transport Error" @if (app('request')->input('errorCode') === '3-D Secure Transport Error') selected @endif>3-D Secure Transport Error</option>
                    <option value="Transaction not permitted to cardholder" @if (app('request')->input('errorCode') === 'Transaction not permitted to cardholder') selected @endif>Transaction not permitted to cardholder</option>
                </select>
            </div>
            <div class="form-group col-lg-1">
                <label for="filterField">Filter Field</label>
                <select name="filterField" id="filterField" class="form-control">
                    <option></option>
                    <option value="Transaction UUID" @if (app('request')->input('filterField') === 'Transaction UUID') selected @endif >Transaction UUID</option>
                    <option value="Customer Email" @if (app('request')->input('filterField') === 'Customer Email') selected @endif>Customer Email</option>
                    <option value="Reference No" @if (app('request')->input('filterField') === 'Reference No') selected @endif>Reference No</option>
                    <option value="Custom Data" @if (app('request')->input('filterField') === 'Custom Data') selected @endif>Custom Data</option>
                    <option value="Card PAN" @if (app('request')->input('filterField') === 'Card PAN') selected @endif>Card PAN</option>
                </select>
            </div>
            <div class="form-group col-lg-1">
                <label for="filterValue">Filter Value</label>
                <input type="text" class="form-control" id="filterValue" name="filterValue" placeholder="Filter Value" value="{{app('request')->input('filterValue')}}">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{route('home')}}" class="btn btn-danger">Reset</a>
        </div>
    </form>
    @if($errors->any())
        <ul>
            <li>{{$errors->first()}}</li>
        </ul>
    @else
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-12">
                @if($response['payload']['prev_page_url'])
                    <a href="{{ route('home',['page' => $response['payload']['current_page'] - 1])  }}">&lt; Previous Page</a>
                @endif
                @if($response['payload']['next_page_url'])
                    <a href="{{ route('home',['page' => $response['payload']['current_page'] + 1])  }}">Next Page &gt;</a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th scope="col">Transaction Id</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($response['payload']['data'] as $row)
                        <tr>
                            <td>{{$row['transaction']['merchant']['transactionId']}}</td>
                            <td>
                                @if (isset($row['customerInfo']))
                                    {{$row['customerInfo']['billingFirstName']}} {{$row['customerInfo']['billingLastName']}}</td>
                            @else
                                No customer information available
                            @endif
                            <td>{{ \Carbon\Carbon::parse($row['created_at'])->format('d/m/Y H:i')}}</td>
                            <td>{{ \Carbon\Carbon::parse($row['updated_at'])->format('d/m/Y H:i')}}</td>
                            <td>
                                <a href="{{  route('transaction',['id' => $row['transaction']['merchant']['transactionId']])  }}" target="_blank">View Transaction</a> ||
                                <a href="{{  route('client',['id' => $row['transaction']['merchant']['transactionId']])  }}" target="_blank">View Client</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @if($response['payload']['prev_page_url'])
                    <a href="{{ route('home',['page' => $response['payload']['current_page'] - 1])  }}">&lt; Previous Page</a>
                @endif
                @if($response['payload']['next_page_url'])
                    <a href="{{ route('home',['page' => $response['payload']['current_page'] + 1])  }}">Next Page &gt;</a>
                @endif
            </div>
        </div>
    @endif
@endsection
