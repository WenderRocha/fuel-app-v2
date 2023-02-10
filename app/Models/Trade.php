<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'management_id',
        'date',
        'assets',
        'payout',
        'value',
        'income',
        'order_type',
        'operational',
        'observation',
        'trade_result'
    ];

    public function management()
    {
        return $this->belongsTo(Management::class);
    }
}
