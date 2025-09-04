<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Brand;
use App\Services\BrandService;
use App\Http\Requests\RegisterBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Events\BrandDeleted;

class BrandController extends Controller
{
    public function __construct(
        private readonly BrandService $brandService
    ) {}

    /** Add a new brand - Frontend */
    public function add(): Response
    {
        return Inertia::render('Brand/Add');
    }

    /** Stores to database from add */
    public function store(RegisterBrandRequest $request): RedirectResponse 
    {
        $this->brandService->create($request->validated());

        return redirect()
                ->back()
                ->with('success', 'Brand added successfully');
    }

    /** Renders Inertia Brand/Manage to display brands to add, edit or delete. */
    public function list(): Response
    {
        $brands = $this->brandService->list(10);
        return Inertia::render('Brand/Manage', ['brands' => $brands]);
    }

    /** Renders FE Inertia Brand/Edit to edit a brand. */
    public function edit(Brand $brand): Response
    {
        return Inertia::render('Brand/Edit', ['brand' => $brand]);
    }

    /** Updates a brand in database, POST request. */
    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse 
    {
        $data = $request->validated();
        $this->brandService->update($brand, $data);

        return redirect()
                ->route('app_brand_manage')
                ->with('success', 'Brand updated successfully');
    }

    /**
     * Deletes a brand from database.
     */
    public function destroy(Brand $brand): RedirectResponse {
        event(new BrandDeleted($brand));
        $this->brandService->delete($brand);

        return redirect()
                ->route('app_brand_manage')
                ->with('success', 'Brand deleted successfully');
    }
}
