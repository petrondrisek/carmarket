<?php
namespace App\Listeners;

use App\Jobs\Image\ProcessImageUpload;
use App\Events\Image\ImageCreatedEvent;

class ImageUploadEventListener
{
    public function handle(ImageCreatedEvent $event): void
    {
        ProcessImageUpload::dispatch($event->image->id, $event->image->folder)->afterCommit();
    }
}