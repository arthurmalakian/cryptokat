<?php

namespace App\Services\Gecko;

use App\Models\Coin;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
class GeckoServiceImpl implements GeckoService
{
    public function getCoin($gecko_id)
    {
        $client = new Client(['base_uri' => 'https://api.coingecko.com']);
        $request = new Request('GET','/api/v3/coins/'.$gecko_id);
        $response = $client->send($request,['timeout' => 5]);
        $data = json_decode($response->getBody());
        $returnData = [
            'coin_title' => $data->name,
            'coin_abbreviation' => $data->symbol,
            'coin_description' => $data->description->en,
            'gecko_id' => $data->id,
            'value' => $data->market_data->current_price->usd,
            'icon_url' => $data->image->small
        ];
        return $returnData;
    }

    public function getCoinHistory($gecko_id,$date)
    {
        $client = new Client(['base_uri' => 'https://api.coingecko.com']);
        $request = new Request('GET','/api/v3/coins/'.$gecko_id.'/history?date='.$date);
        $response = $client->send($request,['timeout' => 5]);
        $data = json_decode($response->getBody());
        $coin = Coin::where('gecko_id',$gecko_id)->firstOrFail();
        $returnData = [
            'date' => Carbon::parse($date),
            'coin_id' => $coin->id,
            'usd_value' => $data->market_data->current_price->usd,
        ];
        return $returnData;
    }
}
