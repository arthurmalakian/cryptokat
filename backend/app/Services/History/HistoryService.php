<?php

namespace App\Services\History;

interface HistoryService
{
    public function getCoinHistory($gecko_id,$date);
    public function getTodayCoinHistory($gecko_id);
    public function createCoinHistoryFromDate($gecko_id,$date);
}
