<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index()
    {
        try {
            $activities = Activity::select(['id', 'admin_id', 'name', 'action', 'created_at', 'updated_at', 'deleted_at'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            return $this->success('admin activities are retrived successfully', $activities);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function destryMultiple()
    {
        DB::beginTransaction();

        try {
            $requestData = request()->all();
            $ids = isset($requestData['ids']) ? $requestData['ids'] : [];

            if (count($ids) > 0) {
                $logs = Activity::whereIn('id', $ids)->delete();
            }

            DB::commit();

            return $this->success('selected activities are deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }
}
