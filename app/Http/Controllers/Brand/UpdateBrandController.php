<?php
namespace App\Http\Controllers\Brand;

use Illuminate\Http\RedirectResponse;

use App\Models\Brand;
use App\Dto\Brand\UpdateBrandDto;
use App\Actions\Brand\UpdateBrandAction;
use App\Http\Requests\Brand\UpdateBrandRequest;

final class UpdateBrandController
{
    public function __invoke(
        Brand $brand, 
        UpdateBrandRequest $request, 
        UpdateBrandAction $action
    ): RedirectResponse 
    {
        $action->execute($brand, UpdateBrandDto::fromRequest($request));

        return redirect()
                ->route('app_brand_edit', ['brand' => $brand->id])
                ->with('success', 'Brand updated successfully');
    }
}