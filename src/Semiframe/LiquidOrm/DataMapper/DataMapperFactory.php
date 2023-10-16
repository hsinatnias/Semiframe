<?php

declare(strict_types=1);

namespace Semiframe\LiquidOrm\DataMapper;

use Semiframe\LiquidOrm\DataMapper\Exception\DataMapperException;

class DataMapperFactory
{

    public function __construct()
    {
    }

    public function create(string $databaseConnectionString, string $dataMapperEnvironmentConfiguration): DataMapperInterface
    {
        $credentials = (new $dataMapperEnvironmentConfiguration([]))->getDatabaseCredentials('mysql');

        $databaseConnectionObject = new $databaseConnectionString($credentials);
        if(!$databaseConnectionObject instanceof DataMapperInterface){
            throw new DataMapperException($databaseConnectionString .'is not a valid database connection object');
        }
        return  new DataMapper($databaseConnectionObject);
    }
}
