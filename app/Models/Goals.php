<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goals extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'name',
        'initial_value',
        'value',
        'description',
        'date_final',
        'profit_wallet',
        'amount',
        'progress',
        'days_remaining'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

}
