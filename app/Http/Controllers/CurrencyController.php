<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Contracts\ExchangeRate as ExchangeRate;

use Illuminate\Http\Request;
use App\Currency;

class CurrencyController extends Controller
{
	protected $exchangeRateService;
	public function __construct(ExchangeRate $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }
	
    public function index()
    {
        return Currency::all();
    }
 
    public function show($code)
    {
		
		try{
			$currency =  Currency::where('code', '=' ,$code)->firstOrFail();
			$newRate = $this->exchangeRateService->rate($code);
			$currency->rate = $newRate;
			return $currency;
		} catch(ModelNotFoundException $e) {
			return response("{'error': 'currency not found'}")->setStatusCode(404);
			
		}
    }
	
}
