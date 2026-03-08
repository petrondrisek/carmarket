<?php
namespace App\Types\Image;

enum ImageState: string
{
    case PENDING = 'pending';
    case UPLOADED = 'uploaded';
    case ERROR = 'error';
    case ERROR_DELETED = 'error_deleted';
}