@extends('layouts.centered')
@section('content')
    @if($errors->any())
        <ul>
            <li>{{$errors->first()}}</li>
        </ul>
    @endif
    <form method="post" action="/login">
        @csrf
        <div class="form-group">
            <label for="email">Email address</label>
            <input name="email" type="email" class="form-control" id="email" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
