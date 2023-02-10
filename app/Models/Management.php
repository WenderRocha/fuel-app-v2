<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'date',
        'qtd_trades',
        'total_investment',
        'qtd_win',
        'qtd_loss',
        'qtd_draw',
        'total_investment',
        'value_win',
        'value_loss',
        'profit',
        'result_percentage',
        'result_percentage_day',
        'day_balance',
        'final_balance',
        'average_profit',
        'take_progress',
        'stop_progress',
        'result_day',
        'key',
        'highlight',
        'dates'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }
}
