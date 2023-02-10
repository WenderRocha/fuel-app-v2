<?php

namespace App\Services\Wallet;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use App\Services\Wallet\WalletServiceInterface;

class WalletService implements WalletServiceInterface
{
    public function findAll()
    {
        return Wallet::all();
    }

    public function find(int $id)
    {
        return Wallet::findOrFail($id);
    }

    public function create(array $data)
    {
        return Wallet::create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->find($id)->update($data);
    }

    public function destroy(int $id)
    {
        return $this->find($id)->delete();
    }

    public function findWith(string $table, int $id)
    {
        return Wallet::with("$table")->findOrFail($id);
    }

    public function resultPercentage(Wallet $wallet)
    {
        $resultPercentage = $wallet->profit / $wallet->initial_balance * 100;
        return number_format((float)$resultPercentage, 2, '.', '');
    }

    public function profit(Wallet $wallet)
    {
        return  $wallet->managements()->sum('profit');
    }

    public function finalBalance(Wallet $wallet, $profit)
    {
        return $wallet->initial_balance + $profit;
    }

    public function takeProfit(Wallet $wallet)
    {
        if($wallet->take_percentage >0 ) {
            return ($wallet->take_percentage  / 100) * $wallet->balance;
        }

        return $wallet->take_profit;

    }

    public function stopLoss(Wallet $wallet)
    {
        if($wallet->stop_percentage >0 ) {
            return ($wallet->stop_percentage  / 100) * $wallet->balance;
        }

        return $wallet->stop_loss;

    }


}
