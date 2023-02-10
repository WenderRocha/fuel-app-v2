<?php

declare(strict_types=1);

namespace App\Services\Wallet;

use App\Models\Wallet;

interface WalletServiceInterface
{
    public function findAll();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function destroy(int $id);
    public function findWith(string $table, int $id);
    public function resultPercentage(Wallet $wallet);
    public function finalBalance(Wallet $wallet, $profit);
    public function profit(Wallet $wallet);
    public function takeProfit(Wallet $wallet);
    public function stopLoss(Wallet $wallet);
}
