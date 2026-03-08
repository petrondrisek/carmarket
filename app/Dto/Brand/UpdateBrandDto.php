<?php
namespace App\Dto\Brand;

use Illuminate\Http\UploadedFile;

use App\Http\Requests\Brand\UpdateBrandRequest;

readonly class UpdateBrandDto
{
    public function __construct(
        public string $name,
        public string $description,
        public bool $isActive,
        public ?UploadedFile $logo = null,
    ) {}

    public static function fromRequest(UpdateBrandRequest $request): self 
    {
        return new self(
            name: $request->validated('name'),
            description: $request->validated('description'),
            isActive: $request->validated('is_active'),
            logo: $request->validated('logo'),
        );
    }
}