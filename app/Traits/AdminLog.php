<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait AdminLog
{
    public function adminLog($action, $data)
    {
        $user = auth::guard('admin')->user();
        $payload = [
            'admin_id' => $user->id,
            'name' => $user->first_name.' '.$user->last_name,
            'action' => $action,
            'data' => $data,
        ];

        DB::beginTransaction();

        try {
            Activity::create($payload);
            DB::commit();

        } catch (Exception $e) {
            return $this->internalServerError();
        }

    }
}
