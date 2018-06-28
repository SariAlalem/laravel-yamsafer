<?php
namespace Database\Seeder;

use Illuminate\Database\Seeder;
use App\Repositories\Contracts\ExchangeRate as ExchangeRate;

class CurrencyTableSeeder extends Seeder
{
	protected $exchangeRateService;
	
	public function __construct(ExchangeRate $exchangeRateService)
    {
		parent::__construct();
        $this->exchangeRateService = $exchangeRateService;
    }
	
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$result = $this->exchangeRateService->list();
		foreach($result->results as $code => $info){
			App\Currency::create([
				'code' => $code,
				'name' => $info->currencyName,
				'symbol' => $info->currencySymbol,
				'rate' => 0.0
			]);
		}
    }
}
