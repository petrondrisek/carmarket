<?php
namespace App\Http\Controllers\Brand;

use App\Dto\Brand\RegisterBrandDto;
use App\Actions\Brand\RegisterBrandAction;
use App\Http\Requests\Brand\RegisterBrandRequest;

final class RegisterBrandController
{
    public function __invoke(RegisterBrandRequest $request, RegisterBrandAction $action)
    {   
        $action->execute(RegisterBrandDto::fromRequest($request));
        
        return redirect()
                ->route('app_brand_manage')
                ->with('success', 'Brand added successfully');
    }
}