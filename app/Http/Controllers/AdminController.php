<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminCreateRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function store(AdminCreateRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $admin = Admin::create($payload->toArray());
            $this->adminLog('ADMIN_ACCOUNT_CREATED', $admin);
            DB::commit();

            return $this->success($admin, 'admin is created successfully');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function index()
    {
        try {
            $admins = Admin::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            return $this->success('admin list are retrived successfully', $admins);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function delIndex()
    {
        try {
            $admins = Admin::onlyTrashed()
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            return $this->success('admin deleted list are retrived successfully', $admins);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        try {
            $admin = Admin::withTrashed()->findOrFail($id);

            return $this->success('Admin is retrived successfully', $admin);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function update($id, AdminUpdateRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $admin = Admin::findOrFail($id);
            $admin->update($payload->toArray());
            $this->adminLog('ADMIN_ACCOUNT_UPDATED', $payload->toArray());
            DB::commit();

            return $this->success('Admin is updated successfully', $payload);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function approve($id)
    {
        DB::beginTransaction();

        try {
            $admin = Admin::findOrFail($id);
            $admin->update(['status' => 'ACTIVE']);
            $this->adminLog('ADMIN_ACCOUNT_APPROVED', $admin);

            DB::commit();

            return $this->success('Admin is approved successfully', $admin);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();

        try {
            $admin = Admin::onlyTrashed()->findOrfail($id);
            $admin->restore();
            $admin->update(['status' => 'ACTIVE']);
            $this->adminLog('ADMIN_ACCOUNT_RESTORED', $admin);

            DB::commit();

            return $this->success('Admin is restored successfully', $admin);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $admin = Admin::findOrfail($id);
            $admin->update(['status' => 'DELETED']);
            $admin->delete($id);
            $this->adminLog('ADMIN_ACCOUNT_DELETED', $admin);

            DB::commit();

            return $this->success('Admin is deleted successfully', $admin);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }
}
