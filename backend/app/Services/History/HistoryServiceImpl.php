<?php

namespace App\Services\History;

use App\Http\Resources\HistoryResource;
use App\Models\Coin;
use App\Models\History;
use App\Services\Gecko\GeckoServiceImpl as GeckoService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HistoryServiceImpl implements HistoryService
{

    private $geckoService;

    public function __construct()
    {
        $this->geckoService = new GeckoService;
    }

    public function getCoinHistory($gecko_id,$date)
    {
        try
        {
            $coin = Coin::where('gecko_id',$gecko_id)->firstOrFail();
            $query = History::where('coin_id',$coin->id)->where('date',$date)->get();
            if($query->isEmpty()){
                return $this->createCoinHistoryFromDate($gecko_id,$date);
            }
            return response(new HistoryResource($query),200);

        }catch(\Exception $exception)
        {
            return response('Not found',404);
        }
    }

    public function getTodayCoinHistory($gecko_id)
    {
        try
        {
            $coin = Coin::where('gecko_id',$gecko_id)->firstOrFail();
            $query = History::where('coin_id',$coin->id)->where('date',Carbon::today()->subDay(1)->format('d-m-Y'))->get();
            if($query->isEmpty()){
                return $this->createCoinHistoryFromDate($gecko_id,Carbon::today()->subDay(1)->format('d-m-Y'));
            }
            return response(new HistoryResource($query),200);
        }catch(\Exception $exception)
        {
            return response('Not found',404);
        }
    }

    public function createCoinHistoryFromDate($gecko_id,$date)
    {
        try
        {
            DB::beginTransaction();
            $historyData = $this->geckoService->getCoinHistory($gecko_id,$date);
            $history = History::updateOrCreate($historyData);
            DB::commit();
            return $history->wasRecentlyCreated ? response(new HistoryResource($history),201) : response(new HistoryResource($history),200);

        }catch(\Exception $exception)
        {
            DB::rollback();
            return response(['Error' => $exception],500);
        }
    }
}
