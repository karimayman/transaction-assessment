<?php

namespace App\Actions;

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
        $congestion = DB::table("congestion_control")->select('status')->where("instance_id", "=", $instanceId)->lockForUpdate()->first();
        if (!$congestion) {
            return false;
        }
        $newStatus = !$congestion->status;

        DB::table('congestion_control')
            ->where('instance_id', $instanceId)
            ->update(['status' => $newStatus]);

        return $newStatus;
        });
    }
}

