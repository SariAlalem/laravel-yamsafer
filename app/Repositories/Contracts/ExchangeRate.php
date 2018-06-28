<?php

namespace App\Repositories\Contracts;

interface ExchangeRate
{
    function rate($code);
	function list();
}

