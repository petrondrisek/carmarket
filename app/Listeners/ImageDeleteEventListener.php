<?php
namespace App\Listeners;

use App\Jobs\Image\ProcessImageDelete;
use App\Events\Image\ImageDeletedEvent;

class ImageDeleteEventListener
{
    public function handle(ImageDeletedEvent $event): void
    {
        ProcessImageDelete::dispatch($event->image->public_path)->afterCommit();
    }
}
