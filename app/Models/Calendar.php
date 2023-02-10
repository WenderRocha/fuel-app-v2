<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'key',
        'highlight'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
