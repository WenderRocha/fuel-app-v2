<?php

namespace App\Enums;

enum OrderType: string
{
    case CALL = 'call';
    case PUT = 'put';
}
