<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case PROGRESS = 'progress';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
}
