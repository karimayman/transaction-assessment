<?php

namespace App\Actions;

use App\Models\Transaction;
use App\Services\BankMatcher;
use App\Services\NotesParser;
use Illuminate\Support\Facades\DB;

class ProcessIncomingRequests
{
    /**
     * Create a new class instance.
     */
    public function __invoke($data,$requestId)
    {
        $transactions = explode("\n", trim($data));
        $bankMatcher = new BankMatcher();
        $notesParser = new NotesParser();
        $bankId = $bankMatcher->detectBank($transactions[0]);
        $bankName = DB::table('banks')->where('id', $bankId)->value('name');
        if ($bankName == 'PayTech') {
            foreach ($transactions as $transaction) {
                $transactionDetails = explode("#", $transaction);
                $date = $transactionDetails[0];
                $amount = $transactionDetails[1];
                $referenceNumber = $transactionDetails[2];
                $notes = $transactionDetails[3]?? "";
                $kvNotes = $notesParser->parseNotes($notes);
                Transaction::insertOrIgnore([
                    'uuid' => $referenceNumber . $bankId,
                    'reference_number' => $referenceNumber,
                    'direction' => 'incoming',
                    'amount' => (float)$amount,
                    'bank_id' => $bankId,
                    'notes' => json_encode($kvNotes),
                    'date' => $date,
                    'stored_request_id' => $requestId
                ]);
            }
        } else {
            foreach ($transactions as $transaction) {
                $transactionDetails = explode("#", $transaction);
                $date = $transactionDetails[2];
                $amount = $transactionDetails[0];
                $referenceNumber = $transactionDetails[1];
                $notes = $transactionDetails[3] ?? "";
                $kvNotes = $notesParser->parseNotes($notes);
                Transaction::insertOrIgnore([
                    'uuid' => $referenceNumber . $bankId,
                    'reference_number' => $referenceNumber,
                    'direction' => 'incoming',
                    'amount' => (float)$amount,
                    'bank_id' => $bankId,
                    'notes' => json_encode($kvNotes),
                    'date' => $date,
                    'stored_request_id' => $requestId
                ]);
            }
        }
    }
}
