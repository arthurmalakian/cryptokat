<?php

namespace App\Http\Controllers;

use App\Services\History\HistoryServiceImpl as HistoryService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    private $historyService;

    public function __construct()
    {
        $this->historyService = new HistoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $gecko_id)
    {
        $date = isset($request->date) ? $request->date : null;
        if($date == null){
            return $this->historyService->getTodayCoinHistory($gecko_id);
        }else{
            return $this->historyService->getCoinHistory($gecko_id,$date);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $gecko_id)
    {
        $date = isset($request->date) ? $request->date : Carbon::today()->subDay(1)->format('d-m-Y');
        return $this->historyService->createCoinHistoryFromDate(
            $gecko_id,$date);
    }

}
