<?php

namespace App\Enums;

enum TradeResult: string
{
    case WIN = 'win';
    case LOSS = 'loss';
    case DRAW = 'draw';
}
