<?php

namespace Database\Seeders;

use App\Models\Coin;
use App\Services\Gecko\GeckoServiceImpl as GeckoService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoinsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $geckoService = new GeckoService;
        $coins = [
            'bitcoin',
            'ethereum',
            'cosmos',
            'terra-luna-2'
            // 'dacxi',
        ];
        foreach($coins as $coin){
            $coinData = $geckoService->getCoin($coin);
            Coin::updateOrCreate([
                'coin_title' => $coinData['coin_title'],
                'coin_abbreviation' => $coinData['coin_abbreviation'],
                'coin_description' => $coinData['coin_description'],
                'gecko_id'=> $coinData['gecko_id'],
            ]);
        }
    }
}
