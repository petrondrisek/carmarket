<?php
namespace App\Types\Car;

enum EngineType: string
{
    case DIESEL = 'diesel';
    case PETROL = 'petrol';
    case ELECTRIC = 'electric';
    case HYBRID = 'hybrid';
}