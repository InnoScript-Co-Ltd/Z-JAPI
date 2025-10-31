<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            $customers = Customer::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            return $this->success('customer list are retrived successfully', $customers);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function store(CustomerStoreRequest $request)
    {
        $payload = collect($request->validated());

        if (isset($payload['nrc_front'])) {
            $nrcFrontPath = $payload['nrc_front']->store('images', 'public');
            $nrcFrontImage = explode('/', $nrcFrontPath)[1];
            $payload['nrc_front'] = $nrcFrontImage;
        }

        if (isset($payload['nrc_back'])) {
            $nrcBackPath = $payload['nrc_back']->store('images', 'public');
            $nrcBackImage = explode('/', $nrcBackPath)[1];
            $payload['nrc_back'] = $nrcBackImage;
        }

        if (isset($payload['photo'])) {
            $photoPath = $payload['photo']->store('images', 'public');
            $photoImage = explode('/', $photoPath)[1];
            $payload['photo'] = $photoImage;
        }

        if (isset($payload['passport_photo'])) {
            $passportImagePath = $payload['passport_photo']->store('images', 'public');
            $passportImageImage = explode('/', $passportImagePath)[1];
            $payload['passport_photo'] = $passportImageImage;
        }

        if (isset($payload['social_link_qrcode'])) {
            $socialLinkPath = $payload['social_link_qrcode']->store('images', 'public');
            $socialLinkImage = explode('/', $socialLinkPath)[1];
            $payload['social_link_qrcode'] = $socialLinkImage;
        }

        if (isset($payload['employer_photo'])) {
            $employeePhotoPath = $payload['employer_photo']->store('images', 'public');
            $employeePhotoImage = explode('/', $employeePhotoPath)[1];
            $payload['employer_photo'] = $employeePhotoImage;
        }

        if (isset($payload['employer_household_photo'])) {
            $employerHouseholdPhotoPath = $payload['employer_household_photo']->store('images', 'public');
            $employerHouseholdPhoto = explode('/', $employerHouseholdPhotoPath)[1];
            $payload['employer_household_photo'] = $employerHouseholdPhoto;
        }

        DB::beginTransaction();

        try {
            $customer = Customer::create($payload->toArray());
            $this->adminLog('CUSTOMER_CREATED', $payload);
            DB::commit();

            return $this->success($customer, 'customer is created successfully');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        try {
            $customer = Customer::findOrFail($id);

            return $this->success('Customer is retrived successfully', $customer);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function update(CustomerUpdateRequest $request, $id)
    {
        $payload = collect($request->validated());

        if (isset($payload['nrc_front'])) {
            $nrcFrontPath = $payload['nrc_front']->store('images', 'public');
            $nrcFrontImage = explode('/', $nrcFrontPath)[1];
            $payload['nrc_front'] = $nrcFrontImage;
        }

        if (isset($payload['nrc_back'])) {
            $nrcBackPath = $payload['nrc_back']->store('images', 'public');
            $nrcBackImage = explode('/', $nrcBackPath)[1];
            $payload['nrc_back'] = $nrcBackImage;
        }

        if (isset($payload['photo'])) {
            $photoPath = $payload['photo']->store('images', 'public');
            $photoImage = explode('/', $photoPath)[1];
            $payload['photo'] = $photoImage;
        }

        if (isset($payload['passport_photo'])) {
            $passportImagePath = $payload['passport_photo']->store('images', 'public');
            $passportImageImage = explode('/', $passportImagePath)[1];
            $payload['passport_photo'] = $passportImageImage;
        }

        if (isset($payload['social_link_qrcode'])) {
            $socialLinkPath = $payload['social_link_qrcode']->store('images', 'public');
            $socialLinkImage = explode('/', $socialLinkPath)[1];
            $payload['social_link_qrcode'] = $socialLinkImage;
        }

        if (isset($payload['employer_photo'])) {
            $employeePhotoPath = $payload['employer_photo']->store('images', 'public');
            $employeePhotoImage = explode('/', $employeePhotoPath)[1];
            $payload['employer_photo'] = $employeePhotoImage;
        }

        if (isset($payload['employer_household_photo'])) {
            $employerHouseholdPhotoPath = $payload['employer_household_photo']->store('images', 'public');
            $employerHouseholdPhoto = explode('/', $employerHouseholdPhotoPath)[1];
            $payload['employer_household_photo'] = $employerHouseholdPhoto;
        }

        DB::beginTransaction();

        try {
            $customer = Customer::findOrFail($id);
            $customer->update($payload->toArray());
            $this->adminLog('CUSTOMER_UPDATE', $payload);
            DB::commit();

            return $this->success('Customer is retrived successfully', $customer);
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
            $this->adminLog('CUSTOMER_DELETED', $customer);

            DB::commit();

            return $this->success('Customer is deleted successfully', $customer);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();

        try {
            $customer = Customer::onlyTrashed()->findOrfail($id);
            $customer->restore();
            $this->adminLog('CUSTOMER_RESTORED', $customer);
            DB::commit();

            return $this->success('Customer is restored successfully', $customer);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }
}
