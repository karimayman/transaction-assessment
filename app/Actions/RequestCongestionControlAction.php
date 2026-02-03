<?php

namespace App\Actions;

use App\Jobs\ProcessBankTransaction;
use App\Jobs\ProcessClientTransaction;
use App\Models\storedRequest;
use Illuminate\Support\Facades\DB;
use Throwable;

class RequestCongestionControlAction
{
    /**
     * Create a new class instance.
     * @throws Throwable
     */
    public function __invoke(): void
    {
        $instanceId = config('app.instance_id');

        DB::transaction(function () use ($instanceId) {
        $congestion = DB::table("congestion_controls")->select('status')->where("instance_id", "=", $instanceId)->lockForUpdate()->first();
        if ($congestion) {
            $unprocessedIncomingRequests = storedRequest::where('processed', '=', false)->where('direction', '=', 'incoming')->get();
            foreach ($unprocessedIncomingRequests as $data) {
                ProcessBankTransaction::dispatch($data->request["data"], $data->id);
                $data->processed = true;
                $data->save();
            }

            return false;
        }
        $newStatus = !$congestion->status;

        DB::table('congestion_controls')
            ->where('instance_id', $instanceId)
            ->update(['status' => $newStatus]);

        return $newStatus;
        });

    }
}

