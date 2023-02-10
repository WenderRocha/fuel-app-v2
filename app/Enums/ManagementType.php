<?php

namespace App\Enums;

enum ManagementType: string
{
    case FIXED = 'fixed';
    case COMPOUND = 'compound';
    case TWOXONE = 'twoxone';
}
