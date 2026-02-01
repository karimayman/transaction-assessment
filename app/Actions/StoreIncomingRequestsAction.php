<?php

namespace App\Actions;

use App\Models\storedRequest;

class StoreIncomingRequestsAction
{
    /**
     * Create a new class instance.
     */
    public function __invoke($data)
    {
       $storedData =  storedRequest::create(['request' => $data]);
        return $storedData->id;
    }
}
