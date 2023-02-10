<?php

declare(strict_types=1);

namespace App\Services\Trade;

use App\Models\Management;

interface TradeServiceInterface
{
    public function findAll();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function destroy(int $id);
    public function qtdTrades(Management $management);
    public function qtdTradesByDay(Management $management, string $date);
    public function qtdTradesByResult(Management $management, string $result);
    public function qtdTotalTradesByResult(Management $management, string $result);
    public function totalInvestment(Management $management);
    public function getValueByResult(Management $management, string $result);
    public function profit(Management $management);
}
