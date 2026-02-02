<?php

use App\Actions\RequestCongestionControlAction;
use App\Http\Controllers\transactionController;
use Illuminate\Support\Facades\Route;


Route::Post('/bank_transaction', [TransactionController::class, 'createBankTransaction']);

Route::Post('/client_transaction', [TransactionController::class, 'createClientTransaction']);

Route::Post('/toggle_congestion', RequestCongestionControlAction::class);
