<?php

namespace App\Services\Management;

use App\Models\Wallet;
use App\Models\Management;

interface ManagementServiceInterface
{
    public function findAll();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function destroy(int $id);
    public function qtdManagements(Wallet $wallet);
    public function totalInvestment(Wallet $wallet);
    public function resultPercentage(Management $management, Wallet $wallet);
    public function resultPercentageDay(Management $management, Wallet $wallet);
    public function dayBalance(Wallet $wallet);
    public function finalBalance(Management $management);
    public function averageProfit(Wallet $wallet);
    public function resultDay(Management $management);
    public function setKey(Management $management);
    public function setHighlight(Management $management);
    public function takeProgress($profit, Wallet $wallet);
    public function stopProgress($value_loss, Wallet $wallet);
}
