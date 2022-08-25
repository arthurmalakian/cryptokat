<?php

namespace App\Http\Controllers;

use App\Http\Requests\Coin\CoinRequest as Request;
use App\Services\Coins\CoinsServiceImpl as CoinsService;


class CoinController extends Controller
{

    private $coinService;

    public function __construct()
    {
        $this->coinService = new CoinsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->coinService->getAllCoins();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->coinService->saveCoin($request->gecko_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $gecko_id
     * @return \Illuminate\Http\Response
     */
    public function show($gecko_id)
    {
        return $this->coinService->getCoin($gecko_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $gecko_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($gecko_id)
    {
        return $this->coinService->deleteCoin($gecko_id);
    }
}
