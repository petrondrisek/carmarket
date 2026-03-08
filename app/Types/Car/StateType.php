<?php
namespace App\Types\Car;

enum StateType: string
{
    case NEW = 'new';
    case USED = 'used';
    case REFURBISHED = 'refurbished';
}