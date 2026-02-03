<?php

namespace App\Jobs;

use App\Actions\ProcessIncomingRequests;
use App\Models\storedRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessBankTransaction implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $data,
        public int $requestId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $dataProcesser = new ProcessIncomingRequests();
        $dataProcesser($this->data, $this->requestId);
        $storedRequest = storedRequest::find($this->requestId);
        if ($storedRequest) {
            $storedRequest->processed = true;
            $storedRequest->save();
        }
    }
}
