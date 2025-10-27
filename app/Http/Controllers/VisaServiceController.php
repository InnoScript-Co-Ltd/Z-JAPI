<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisaServiceStoreRequest;
use App\Http\Requests\VisaServiceUpdateRequest;
use App\Models\VisaService;
use Illuminate\Support\Facades\DB;

class VisaServiceController extends Controller
{
    public function index()
    {
        try {
            $visaServices = VisaService::select(['id', 'name', 'passport', 'passport_image', 'service_type', 'visa_type', 'visa_entry_date', 'visa_expiry_date', 'appointment_date', 'status', 'new_visa_expired_date', 'created_at', 'updated_at', 'deleted_at'])
                ->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            return $this->success('visa services are retrived successfully', $visaServices);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function show($id)
    {

        try {
            $visaService = VisaService::find($id);

            if ($visaService === null) {
                return $this->notFound('visa service does not exist');
            }

            return $this->success('visa service is retrived successfully', $visaService);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function update(VisaServiceUpdateRequest $request, $id)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $visaService = VisaService::find($id);
            $visaService->update($payload->toArray());
            $this->adminLog('UPDATE_VISA_SERVICE', $payload->toArray());
            DB::commit();

            return $this->success('visa service is updated successfully', $visaService);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function store(VisaServiceStoreRequest $request)
    {
        $payload = collect($request->validated());

        if (isset($payload['passport_image'])) {
            $passportImagePath = $payload['passport_image']->store('images', 'public');
            $passportImage = explode('/', $passportImagePath)[1];
            $payload['passport_image'] = $passportImage;
        }

        DB::beginTransaction();

        try {
            $visaService = VisaService::create($payload->toArray());
            $this->adminLog('CREATE_VISA_SERVICE', $payload->toArray());
            DB::commit();

            return $this->success('visa service is created successfully', $visaService);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }
}
