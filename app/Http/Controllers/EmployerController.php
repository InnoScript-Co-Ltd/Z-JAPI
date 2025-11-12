<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployerStoreRequest;
use App\Http\Requests\EmployerUpdateRequest;
use App\Models\Employer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployerController extends Controller
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
            $employers = Employer::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            return $this->success('employer list are retrived successfully', $employers);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function store(EmployerStoreRequest $request)
    {
        $payload = collect($request->validated());

        if (isset($payload['household_photo'])) {
            $payload['household_photo'] = $this->generateFileName('EMPLOYER_HOUSEHOLD', $payload['name'], $payload['household_photo']);
        }

        if (isset($payload['national_card_photo'])) {
            $payload['national_card_photo'] = $this->generateFileName('NATIONAL_ID_CARD', $payload['name'], $payload['national_card_photo']);
        }

        DB::beginTransaction();

        try {
            $employer = Customer::create($payload->toArray());
            $this->adminLog('EMPLOYER_CREATED', $payload);
            DB::commit();

            return $this->success($employer, 'employer is created successfully');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        try {
            $employer = Employer::findOrFail($id);

            return $this->success('Employer is retrived successfully', $employer);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function update(EmployerUpdateRequest $request, $id)
    {
        $employer = collect($request->validated());

        if (isset($payload['household_photo'])) {
            $payload['household_photo'] = $this->generateFileName('EMPLOYER_HOUSEHOLD', $payload['name'], $payload['household_photo']);
        }

        if (isset($payload['national_card_photo'])) {
            $payload['national_card_photo'] = $this->generateFileName('NATIONAL_ID_CARD', $payload['name'], $payload['national_card_photo']);
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
