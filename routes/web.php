<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Reporting\Command\GetClient;
use App\Reporting\Command\GetTransaction;
use App\Reporting\Command\Login;
use App\Reporting\Command\TransactionQuery;
use App\Reporting\Command\TransactionReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request, TransactionQuery $transactionQuery) {
    $res = $transactionQuery->run([
        'fromDate'      => $request->get('fromDate', '2015-01-01'),
        'toDate'        => $request->get('toDate', Carbon::now()->format('Y-m-d')),
        'status'        => $request->get('status'),
        'operation'     => $request->get('operation'),
        'merchantId'    => $request->get('merchantId'),
        'acquirerId'    => $request->get('acquirerId'),
        'paymentMethod' => $request->get('paymentMethod'),
        'errorCode'     => $request->get('errorCode'),
        'filterField'   => $request->get('filterField'),
        'filterValue'   => $request->get('filterValue'),
        'page'          => $request->get('page'),
    ]);
    if (!$res['success']) {
        return view('welcome')->withErrors($res['error']);
    }

    return view('welcome', ['response' => $res]);
})->middleware('auth')->name('home');

Route::get('/report', function (Request $request, TransactionReport $transactionReport) {
    $res = $transactionReport->run([
        'fromDate' => $request->get('fromDate', '2015-01-01'),
        'toDate'   => $request->get('toDate', Carbon::now()->format('Y-m-d')),
        'merchant' => $request->get('merchant'),
        'acquirer' => $request->get('acquirer'),
    ]);
    if (!$res['success']) {
        return view('report')->withErrors($res['error']);
    }

    return view('report', ['response' => $res]);
})->middleware('auth')->name('report');

Route::get('/transaction/{id}', function (GetTransaction $getTransaction, $id) {
    $res = $getTransaction->run([
        'transactionId' => $id,
    ]);

    return view('transaction', ['response' => $res]);
})->middleware('auth')->name('transaction');

Route::get('/client/{id}', function (GetClient $getClient, $id) {
    $res = $getClient->run([
        'transactionId' => $id,
    ]);

    return view('client', ['response' => $res]);
})->middleware('auth')->name('client');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request, Login $login) {
    $result = $login->run([
        'email'    => $request->get('email'),
        'password' => $request->get('password'),
    ]);
    if ($result['success']) {
        return redirect('/');
    }

    return redirect('/login')->withErrors(['msg' => $result['error']]);
});
