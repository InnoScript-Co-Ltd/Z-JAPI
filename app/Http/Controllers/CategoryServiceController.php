<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryServiceStoreRequest;
use App\Http\Requests\CategoryServiceUpdateRequest;
use App\Models\CategoryService;
use Illuminate\Support\Facades\DB;

class CategoryServiceController extends Controller
{
    public function index()
    {
        try {
            $categoryServices = CategoryService::with(['category'])
                ->filterQuery()
                ->filterDateQuery()
                ->sortingQuery()
                ->searchQuery()
                ->paginationQuery();

            return $this->success('category services list are retrived successfully', $categoryServices);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        try {
            $categoryService = CategoryService::with(['category'])->findOrFail($id);

            return $this->success('Category service is retrived successfully', $categoryService);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $categoryService = CategoryService::findOrfail($id);
            $categoryService->delete($id);
            $this->adminLog('CATEGORY_SERVICE_DELETED', $category);
            DB::commit();

            return $this->success('Category service is deleted successfully', null);
        } catch (Exception $e) {
            DB::rollback();

            return $this->internalServerError();
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();

        try {
            $categoryService = CategoryService::onlyTrashed()->findOrfail($id);
            $categoryService->restore();
            $this->adminLog('CATEGORY_SERVICE_RESTORED', $categoryService);
            DB::commit();

            return $this->success('Category service is restored successfully', $categoryService);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function store(CategoryServiceStoreRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $categoryService = CategoryService::create($payload->toArray());
            $this->adminLog('CATEGORY_SERVICE_CREATED', $payload);
            DB::commit();

            return $this->success('Category service is store successfully', $categoryService);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function update($id, CategoryServiceUpdateRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $categoryService = CategoryService::findOrFail($id);
            $categoryService->update($payload->toArray());
            $this->adminLog('CATEGORY_SERVICE_UPDATE', $payload);
            DB::commit();

            return $this->success('Category service is updated successfully', $categoryService);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }
}
