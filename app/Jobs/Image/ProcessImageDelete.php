<?php
namespace App\Jobs\Image;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

use App\Models\Image;

final class ProcessImageDelete implements ShouldQueue
{
    use Dispatchable, Queueable;

    public int $tries = 3;
    public int $backoff = 10;

    public function __construct(
        public string $publicPath
    ) {}

    public function handle(): void
    {
        if (!$this->publicPath) {
            throw new \Exception("Image (Path: {$this->publicPath}) not found.");
        }

        if(!Storage::disk('public')->delete($this->publicPath)) {
            throw new \Exception("Error deleting file. (Public path: {$this->publicPath})");
        };
    }
}