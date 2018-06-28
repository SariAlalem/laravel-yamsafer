<?php

namespace App\Repositories;

use App\Repositories\Contracts\ExchangeRate as ExchangeRate;
use Illuminate\Contracts\Cache\Repository as Cache;

class FreeCCExchangeRate implements ExchangeRate {
	private $baseUrl="https://free.currencyconverterapi.com/api/v5/convert?compact=y&q=USD_";
	protected $cache;
	static $CACHE_PREFIX = "ExchangeRate_";
	static $CACHE_EXPIRY_MINUTES = 5;
	
	public function __construct(Cache $cache) {
		$this->cache = $cache;
    }
	
	function rate($code) {
		$code = strtoupper($code);
		$rate = $this->getFromCache($code);
		if(!$rate) {
			$jsonObj =file_get_contents($this->baseUrl.$code);
			$jsonObj =  json_decode($jsonObj);
			$newCode = 'USD_'.$code;
			$rate = $jsonObj->{$newCode}->val;
			$this->updateCache($code,$rate);
		}
        return $rate;
	}
	
	function list(){
		$jsonObj =file_get_contents("https://free.currencyconverterapi.com/api/v5/currencies");
        $jsonObj =  json_decode($jsonObj);
		return $jsonObj;
	}
	function getFromCache($code){
		return $this->cache->get(self::$CACHE_PREFIX.$code);
	
	}
	
	function updateCache($code, $rate){
		$this->cache->put(self::$CACHE_PREFIX.$code,$rate,self::$CACHE_EXPIRY_MINUTES);
	}
}