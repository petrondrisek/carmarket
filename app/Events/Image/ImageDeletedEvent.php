<?php
namespace App\Events\Image;

use App\Models\Image;

final class ImageDeletedEvent
{
    public function __construct(public Image $image)
    {
    }
}