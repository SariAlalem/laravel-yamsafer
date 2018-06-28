<?php
namespace App\Listeners;
use Illuminate\Database\Events\QueryExecuted;

class SaveQueryToFileListener
{
    public function __construct(QueryExecuted $queryExecuted)
    {
        die($queryExecuted->sql);
    }
}