<?php

namespace App\Actions;

use App\Models\storedRequest;

class StoreOutgoingRequestsAction
{
    /**
     * Create a new class instance.
     */
    public function __construct($data)
    {
        $storedData =  storedRequest::create(['request' =>['data'=> $data], 'processed'=>false, 'direction'=>'outgoing']);
        return $storedData->id;
    }
}
