<?php
namespace App\Jobs\Image;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

use App\Models\Image;

final class ProcessImageUpload implements ShouldQueue
{
    use Dispatchable, Queueable;

    public int $tries = 3;
    public int $backoff = 10; // waiting 10 seconds in between retries

    public function __construct(
        public int $imageId,
        public string $folder = 'uploads'
    ) {}

    public function handle(): void
    {
        $image = Image::find($this->imageId);
        
        if (!$image || !$image->temp_path) {
            return;
        }

        $tempFileContent = Storage::disk('local')->get($image->temp_path);
        
        // Whatever to do with image
        $targetPath = $this->folder . '/' . $image->filename;
        $successUpload = Storage::disk('public')->put($targetPath, $tempFileContent);
        
        if(!$successUpload) {
            throw new \Exception('Error moving file.');
        };

        $image->makeReady($targetPath);

        // Delete temp file
        Storage::disk('local')->delete($image->temp_path);
    }

    public function failed(\Throwable $exception): void 
    {
        if ($image = Image::find($this->imageId)) {
            $image->makeError();
        }
    }
}