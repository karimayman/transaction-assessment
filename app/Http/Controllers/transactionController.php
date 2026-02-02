<?php

namespace App\Http\Controllers;

use App\Actions\createClientXml;
use App\Actions\ProcessIncomingRequests;
use App\Actions\StoreIncomingRequestsAction;
use App\Models\congestionControl;
use App\Models\storedRequest;
use Illuminate\Http\Request;
use App\Dto\xmlDto;

class transactionController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function createBankTransaction(Request $request)
    {
        $dataCongestion = CongestionControl::where('instance_id', config('app.instance_id'))->value('status');
        $data = $request->getContent();
        $dataStorage = new StoreIncomingRequestsAction();
        $requestId = $dataStorage($data);
        if($dataCongestion){
            StoredRequest::where('id', $requestId)->update(['processed' => !$dataCongestion]);
            return response()->json(['message' => 'ok'], 200);
        }
        $dataProcesser = new ProcessIncomingRequests();
        $dataProcesser($data, $requestId);
        StoredRequest::where('id', $requestId)->update(['processed' => !$dataCongestion]);
        return response()->json(['message' => 'ok'], 200);

    }

    public function createClientTransaction(Request $request){
        $xmlData = $request->validate([
            'reference' => 'required|string',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'sender.account_number' => 'required|string',
            'receiver.account_number' => 'required|string',
            'notes' => 'array',
            'payment_type' => 'nullable|integer',
            'charge_details' => 'nullable|string',
        ]);
        $xmlDto = new xmlDto(
            reference : $request->reference,
            date: $request->date,
            amount: $request->amount,
            currency: $request->currency,
            senderAccount: $request->sender['account_number'],
            receiverAccount: $request->receiver['account_number'],
            notes: $request->notes,
            paymentType: $request->payment_type,
            chargeDetails: $request->charge_details,
        );
        $xml = new createClientXml();
        $response = $xml($xmlDto);
        return response($response, 200)->header('Content-Type', 'text/xml');

    }
}
