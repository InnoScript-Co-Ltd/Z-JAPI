<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployerUpdateRequest;
use App\Http\Requests\OnboardingServiceStoreRequest;
use App\Models\OnboardingService;
use Illuminate\Support\Facades\DB;

class OnboardingServiceController extends Controller
{
    public function index()
    {
        try {
            $onboardingServices = OnboardingService::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            return $this->success('Onboarding service list are retrived successfully', $onboardingServices);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function store(OnboardingServiceStoreRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $onboardingService = OnboardingService::create($payload->toArray());
            $this->adminLog('ONBOARDING_SERVICE_CREATED', $payload);
            DB::commit();

            return $this->success('Onboarding Service is created successfully', $onboardingService);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        try {
            $onboardingService = OnboardingService::findOrFail($id);

            return $this->success('Onboarding service is retrived successfully', $onboardingService);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function update(EmployerUpdateRequest $request, $id)
    {
        $payload = collect($request->validated());

        if (isset($payload['household_photo'])) {
            $payload['household_photo'] = $this->generateFileName('EMPLOYER_HOUSEHOLD', $payload['full_name'], $payload['household_photo']);
        }

        if (isset($payload['national_card_photo'])) {
            $payload['national_card_photo'] = $this->generateFileName('NATIONAL_ID_CARD', $payload['full_name'], $payload['national_card_photo']);
        }

        if (isset($payload['update_documents'])) {
            $payload['update_documents'] = explode(',', $payload['update_documents']);
        }

        if (isset($payload['company_documents'])) {

            foreach ($payload['company_documents'] as $index => $payloadFile) {
                $fileNames[] = $payload['company_documents'] = $this->generateFileName('EMPLOYER_COMPANY_FILE', $payload['full_name'], $payloadFile);
            }

            $payload['company_documents'] = $fileNames;
        }

        if (isset($payload['company_documents']) && isset($payload['update_documents'])) {
            $payload['company_documents'] = array_merge($payload['company_documents'], $payload['update_documents']);
        }

        DB::beginTransaction();

        try {
            $employer = Employer::findOrFail($id);

            if (! isset($payload['company_documents']) && isset($payload['update_documents'])) {
                $payload['company_documents'] = $payload['update_documents'];
            }

            $employer->update($payload->toArray());
            $this->adminLog('EMPLOYER_UPDATE', $payload);
            DB::commit();

            return $this->success('Employer is retrived successfully', $employer);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $customer = Customer::findOrfail($id);
            $customer->delete($id);
            $this->adminLog('EMPLOYER_DELETED', $customer);
            DB::commit();

            return $this->success('Customer is deleted successfully', $customer);
        } catch (Exception $e) {
            DB::rollback();

            return $this->internalServerError();
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();

        try {
            $customer = Customer::onlyTrashed()->findOrfail($id);
            $customer->restore();
            $this->adminLog('EMPLOYER_RESTORED', $customer);
            DB::commit();

            return $this->success('Customer is restored successfully', $customer);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }
}
