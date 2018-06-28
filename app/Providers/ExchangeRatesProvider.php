<?php namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
 
class ExchangeRatesProvider extends ServiceProvider {
	
	public function register()
	{
		$this->app->bind(
			\App\Repositories\Contracts\ExchangeRate::class,
			\App\Repositories\FreeCCExchangeRate::class
		);
				\DB::listen(function($sql)
						{
								$query = $sql->sql;
								Storage::append('logs/query.log', $query."\r\n");
								die($query);
			}); 
	}
}