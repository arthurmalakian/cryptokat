<?php

namespace App\Services\Coins;

interface CoinsService
{
    public function getAllCoins();
    public function getCoin($gecko_id);
    public function saveCoin($gecko_id);
    public function deleteCoin($coin_id);
}
