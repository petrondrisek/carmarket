<?php
namespace App\Http\Controllers\Brand;

use Illuminate\Http\RedirectResponse;

use App\Models\Brand;
use App\Actions\Brand\DeleteBrandAction;

final class DeleteBrandController
{
    public function __invoke(Brand $brand, DeleteBrandAction $action): RedirectResponse 
    {
        $action->execute($brand);
        
        return redirect()
                ->route('app_brand_manage')
                ->with('success', 'Brand deleted successfully');
    }
}