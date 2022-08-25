<?php

namespace App\Services\Gecko;

interface GeckoService
{
    public function getCoin($gecko_id);
    public function getCoinHistory($gecko_id,$date);
}
