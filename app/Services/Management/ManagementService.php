<?php

declare(strict_types=1);

namespace App\Services\Management;

use App\Enums\ManagementType;
use App\Models\Wallet;
use App\Models\Management;
use Illuminate\Support\Facades\DB;
use App\Services\Trade\TradeServiceInterface;
use App\Services\Management\ManagementServiceInterface;
use App\Services\Wallet\WalletServiceInterface;

class ManagementService implements ManagementServiceInterface
{
    public function __construct(
        protected TradeServiceInterface $tradeService,
        protected WalletServiceInterface $walletService
    )
    {

    }

    public function findAll()
    {
        return Management::all();
    }

    public function find(int $id)
    {
        return Management::findOrFail($id);
    }

    public function create(array $data)
    {
        return Management::create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->find($id)->update($data);
    }

    public function destroy(int $id)
    {
        return $this->find($id)->delete();
    }

    public function qtdManagements(Wallet $wallet)
    {
       return  $wallet->managements()->count();
    }

    public function totalInvestment(Wallet $wallet)
    {
        return  $wallet->managements()->sum('value');
    }

    public function resultPercentage(Management $management, Wallet $wallet)
    {
        $resultPercentage = $this->tradeService->profit($management) / $wallet->initial_balance * 100;
        return number_format((float)$resultPercentage, 2, '.', '');
    }

    public function resultPercentageDay(Management $management, Wallet $wallet)
    {
        $resultPercentage = $this->tradeService->profit($management) / $management->day_balance * 100;
        return number_format((float)$resultPercentage, 2, '.', '');
    }

    public function dayBalance(Wallet $wallet)
    {
        return $wallet->balance;
    }

    public function finalBalance(Management $management)
    {
        return $management->day_balance + $this->tradeService->profit($management);
    }

    public function averageProfit(Wallet $wallet)
    {
        return $wallet->profit / $this->qtdManagements($wallet);
    }

    public function resultDay(Management $management): string
    {
        $win = $this->tradeService->getValueByResult($management, 'win');
        $loss = $this->tradeService->getValueByResult($management, 'loss');

        if($win > $loss) {
            return 'win';
        }else if($this->tradeService->profit($management) == 0){
            return 'draw';
        }

        return 'loss';

    }

    public function setKey(Management $management)
    {
        if($this->tradeService->qtdTradesByDay($management, date('Y-m-d')) == 0) {
            return 'no_trade';
        }

        return $this->resultDay($management);

    }

    public function setHighlight(Management $management)
    {
       return match($this->resultDay($management)) {
            'win' => 'green',
            'draw' =>  'yellow',
            'loss' => 'red',
            'no_trade' => 'gray',
            default => throw new \Exception('Unsupported'),
        };
    }

    public function takeProgress($profit, Wallet $wallet)
    {
        if($wallet->management_type == ManagementType::COMPOUND->value) {
            return (($profit * 100) / $wallet->take_percentage) / 100;
        }

        return (($profit * 100) / $wallet->take_profit) / 100;

    }

    public function stopProgress($value_loss, Wallet $wallet)
    {
        if($wallet->management_type == ManagementType::COMPOUND->value) {
            return (($value_loss * 100) / $wallet->stop_percentage) / 100;
        }
        return (($value_loss * 100) / $wallet->stop_loss) / 100;
    }

}
