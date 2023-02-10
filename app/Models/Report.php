<?php

namespace App\Models;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'qtd_trades',
        'qt_win',
        'qtd_loss',
        'qtd_draw',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
