<?php

namespace App\Http\Controllers;

use App\Actions\ProcessIncomingRequests;
use App\Actions\StoreIncomingRequestsAction;
use App\Models\congestionControl;
use App\Models\storedRequest;
use Illuminate\Http\Request;

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
        $dataProcesser($data);
        StoredRequest::where('id', $requestId)->update(['processed' => !$dataCongestion]);
        return response()->json(['message' => 'ok'], 200);

    }

    public function createClientTransaction(Request $request){


    }
}
