<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            $services = Service::with(['category'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            return $this->success('service list are retrived successfully', $services);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function store(ServiceStoreRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $payload['status'] = 'ACTIVE';
            $service = Service::create($payload->toArray());
            $this->adminLog('SERVICE_CREATED', $payload);
            DB::commit();

            return $this->success('service is created successfully', $service);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        try {
            $service = Service::findOrFail($id);

            return $this->success('Service is retrived successfully', $service);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function update($id, ServiceUpdateRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $service = Service::findOrFail($id);
            $service->update($payload->toArray());
            $this->adminLog('SERVICE_UPDATE', $payload);
            DB::commit();

            return $this->success('Service is retrived successfully', $service);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $service = Service::findOrfail($id);
            $service->delete($id);
            $this->adminLog('SERVICE_DELETED', $service);
            DB::commit();

            return $this->success('Service is deleted successfully', $service);
        } catch (Exception $e) {
            DB::rollback();

            return $this->internalServerError();
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();

        try {
            $service = Service::onlyTrashed()->findOrfail($id);
            $service->restore();
            $this->adminLog('SERVICE_RESTORED', $service);
            DB::commit();

            return $this->success('Customer is restored successfully', $service);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }
}
