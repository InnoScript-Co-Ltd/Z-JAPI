<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    protected function generateFileName($prefix, $text, $file)
    {
        if (isset($file)) {
            $textArray = explode(' ', strtoupper($text));
            $fileName = 'Z&J_'.$prefix.'_'.implode('_', $textArray);
            $now = Carbon::now('Asia/Bangkok')->format('Y_m_d_His').'_';
            $fileRename = $now.$fileName.'.'.$file->getClientOriginalExtension();

            $file->storeAs('uploads', $fileRename, 'public');

            return $fileRename;
        }

        return null;
    }

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

        $payload['nrc_front'] = $this->generateFileName('NRC_FRONT', $payload['name'], $payload['nrc_front']);
        $payload['nrc_back'] = $this->generateFileName('NRC_BACK', $payload['name'], $payload['nrc_back']);
        $payload['photo'] = $this->generateFileName('PROFILE', $payload['name'], $payload['photo']);
        $payload['passport_photo'] = $this->generateFileName('PASSPORT', $payload['name'], $payload['passport_photo']);
        $payload['social_link_qrcode'] = $this->generateFileName('SOCIAL_MEDIA_APP_QRCODE', $payload['name'], $payload['social_link_qrcode']);
        $payload['household_photo'] = $this->generateFileName('HOUSEHOLD', $payload['name'], $payload['household_photo']);

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

        $payload['nrc_front'] = $this->generateFileName('NRC_FRONT', $payload['name'], $payload['nrc_front']);
        $payload['nrc_back'] = $this->generateFileName('NRC_BACK', $payload['name'], $payload['nrc_back']);
        $payload['photo'] = $this->generateFileName('PROFILE', $payload['name'], $payload['photo']);
        $payload['passport_photo'] = $this->generateFileName('PASSPORT', $payload['name'], $payload['passport_photo']);
        $payload['social_link_qrcode'] = $this->generateFileName('SOCIAL_MEDIA_APP_QRCODE', $payload['name'], $payload['social_link_qrcode']);
        $payload['household_photo'] = $this->generateFileName('HOUSEHOLD', $payload['name'], $payload['household_photo']);

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
            $this->adminLog('CUSTOMER_RESTORED', $customer);
            DB::commit();

            return $this->success('Customer is restored successfully', $customer);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }
}
