<?php
namespace App\Events\Image;

use App\Models\Image;

final class ImageCreatedEvent
{
    public function __construct(public Image $image)
    {
    }
}