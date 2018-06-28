<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Contracts\ExchangeRate as ExchangeRate;

class CurrencySeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds the currencies tabel from  https://free.currencyconverterapi.com/api/v5/currencies';

    /**
     * Create a new command instance.
     *
     * @return void
     */	 
 	protected $exchangeRateService;
	
	public function __construct(ExchangeRate $exchangeRateService)
    {
		parent::__construct();
        $this->exchangeRateService = $exchangeRateService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$result = $this->exchangeRateService->list();
		foreach($result->results as $code => $info){
			$symbol = '';
			if(isset($info->currencySymbol)){
				$symbol = $info->currencySymbol;
			}
			echo "Adding Currency: ".$code." with details:\r\n";
			echo json_encode($info)."\r\n";
			
			//TODO if needed, check if the currency already exists
			\App\Currency::create([
				'code' => $code,
				'name' => $info->currencyName,
				'symbol' => $symbol,
				'rate' => 0.0
			]);
		}
    }
}
