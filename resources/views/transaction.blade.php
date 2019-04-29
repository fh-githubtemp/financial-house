@extends('layouts.layout')
@section('content')
    <h1>View Transaction</h1>
    <div class="row">
        <div class="col-lg-12">
                <pre>
                    <code>
                        {{json_encode($response['payload'],JSON_PRETTY_PRINT)}}
                    </code>
                </pre>
        </div>
    </div>
@endsection
