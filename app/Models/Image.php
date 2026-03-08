<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\Image\{ImageCreatedEvent, ImageDeletedEvent};

class Image extends Model
{
    protected $fillable = [
        'filename',
        'folder',
        'temp_path',
        'public_path',
        'state'
    ];

    public function makeReady(string $publicPath) {
        $this->update([
            'state' => \App\Types\Image\ImageState::UPLOADED->value,
            'public_path' => $publicPath
        ]);
    }

    public function makeError($delete = false) {
        $this->update([
            'state' => $delete 
                ? \App\Types\Image\ImageState::ERROR_DELETED->value 
                : \App\Types\Image\ImageState::ERROR->value
        ]);
    }

    protected $dispatchesEvents = [
        'created' => ImageCreatedEvent::class,
        'deleted' => ImageDeletedEvent::class,
    ];
}
