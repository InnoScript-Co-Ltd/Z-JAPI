<?php

namespace App\Http\Controllers;

use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        try {
            $activities = Activity::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            return $this->success('admin activities are retrived successfully', $activities);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }
}
