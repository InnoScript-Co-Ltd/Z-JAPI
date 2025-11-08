<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Categories::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            return $this->success('categories list are retrived successfully', $categories);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function show($id)
    {
        try {
            $category = Categories::findOrFail($id);

            return $this->success('Category is retrived successfully', $category);
        } catch (Exception $e) {
            return $this->internalServerError();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $category = Categories::findOrfail($id);
            $category->delete($id);
            $this->adminLog('CATEGORY_DELETED', $category);
            DB::commit();

            return $this->success('Category is deleted successfully', null);
        } catch (Exception $e) {
            DB::rollback();

            return $this->internalServerError();
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();

        try {
            $category = Categories::onlyTrashed()->findOrfail($id);
            $category->restore();
            $this->adminLog('CATEGORY_RESTORED', $category);
            DB::commit();

            return $this->success('Category is restored successfully', $category);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function store(CategoryStoreRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $category = Categories::create($payload->toArray());
            $this->adminLog('CATEGORY_UPDATE', $payload);
            DB::commit();

            return $this->success('Service is retrived successfully', $category);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }

    public function update($id, CategoryUpdateRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $category = Categories::findOrFail($id);
            $category->update($payload->toArray());
            $this->adminLog('CATEGORY_UPDATE', $payload);
            DB::commit();

            return $this->success('Category is retrived successfully', $category);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->internalServerError();
        }
    }
}
