<?php

namespace App\Services\Coins;

use App\Http\Resources\CoinResource;
use App\Services\Gecko\GeckoServiceImpl as GeckoService;
use App\Models\Coin;
use Illuminate\Support\Facades\DB;

class CoinsServiceImpl implements CoinsService
{

    private $geckoService;

    public function __construct()
    {
        $this->geckoService = new GeckoService;
    }

    public function getAllCoins()
    {
        $query = Coin::orderBy('coin_title','asc')->get();
        return response(new CoinResource($query),200);
    }

    public function getCoin($gecko_id)
    {
        try
        {
            $query = Coin::where('gecko_id',$gecko_id)->firstOrFail();
            return response(new CoinResource($query),200);
        }catch(\Exception $exception)
        {
            return response('Not found',404);
        }
    }

    public function saveCoin($gecko_id)
    {
        try
        {
            DB::beginTransaction();

            $coinData = $this->geckoService->getCoin($gecko_id);

            $coin = Coin::updateOrCreate([
                'coin_title' => $coinData['coin_title'],
                'coin_abbreviation' => $coinData['coin_abbreviation'],
                'coin_description' => $coinData['coin_description'],
                'gecko_id'=> $coinData['gecko_id'],
            ]);

            if($coinData['icon_url'] != null ){
                if(isset($coin->media[0])){
                    $coin->media[0]->delete();
                }
                $coin->addMediaFromUrl($coinData['icon_url'])->toMediaCollection('coin_images');
            }

            DB::commit();

            return $coin->wasRecentlyCreated ? response(new CoinResource($coin),201) : response(new CoinResource($coin),200);

        }catch(\Exception $exception)
        {
            DB::rollback();
            return response(['Error' => $exception],500);
        }
    }

    public function deleteCoin($gecko_id)
    {
        try
        {
            $coin = Coin::where('gecko_id',$gecko_id)->firstOrFail();
            $coin->delete();
            return response('Coin deleted.',200);
        }catch(\Exception $exception)
        {
            return response('Not found',404);
        }
    }

}
