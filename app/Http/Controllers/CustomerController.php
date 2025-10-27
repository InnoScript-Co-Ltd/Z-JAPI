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

    public function update($id, CustomerUpdateRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $customer = Customer::findOrFail($id);
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
