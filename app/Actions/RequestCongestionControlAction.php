<?php

namespace App\Actions;

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
        if (!$congestion) {
            // TODO create a job to process all unprocessed requests in the background
            $unprocessedRequests = storedRequest::where('processed', '=', false)->get();
            $dataProcesser = new ProcessIncomingRequests();
            foreach ($unprocessedRequests as $data) {
                $dataProcesser($data->request);
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

