<?php

namespace App\Services\Trade;

use App\Models\Management;
use App\Models\Trade;
use Illuminate\Support\Facades\DB;
use App\Services\Trade\TradeServiceInterface;

class TradeService implements TradeServiceInterface
{
    public function findAll()
    {
        return Trade::all();
    }

    public function find(int $id)
    {
        return Trade::findOrFail($id);
    }

    public function create(array $data)
    {
        return Trade::create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->find($id)->update($data);
    }

    public function destroy(int $id)
    {
        return $this->find($id)->delete();
    }

    public function qtdTrades(Management $management)
    {
        //return DB::table('trades')->whereDate('created_at', date('Y-m-d'))->get()->count();
        return $management->trades()->count();
    }

    public function qtdTradesByDay(Management $management, string $date)
    {
        return $management->trades()->whereDate('created_at', $date)->get()->count();
    }

    public function qtdTradesByResult(Management $management, string $result)
    {
        return $management->trades()->where('trade_result', "$result")
                                  ->whereDate('created_at', date('Y-m-d'))->get()->count();
    }

    public function qtdTotalTradesByResult(Management $management, string $result)
    {
        return $management->trades()->where('trade_result', "$result")->count();
    }

    public function totalInvestment(Management $management)
    {
        return $management->trades()->whereDate('created_at', date('Y-m-d'))->get()->sum('value');
    }

    public function getValueByResult(Management $management, string $result)
    {
        if($result == 'loss') {
            return $management->trades()->where('trade_result', "$result")
                                      ->whereDate('created_at', date('Y-m-d'))
                                      ->get()
                                      ->sum('value');
        }

        return $management->trades()->where('trade_result', "$result")
                                ->whereDate('created_at', date('Y-m-d'))
                                ->get()
                                ->sum('income');
    }

    public function profit(Management $management)
    {
        $win = $management->trades()->where('trade_result', 'win')
                                  ->whereDate('created_at', date('Y-m-d'))
                                  ->get()
                                  ->sum('income');

        $loss = $management->trades()->where('trade_result', 'loss')
                                   ->whereDate('created_at', date('Y-m-d'))
                                   ->get()
                                   ->sum('value');
        return $win - $loss;
    }

}
