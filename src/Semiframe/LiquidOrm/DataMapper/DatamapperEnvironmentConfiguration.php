<?php
declare(strict_types=1);

namespace Semiframe\LiquidOrm\DataMapper;

use Semiframe\LiquidOrm\DataMapper\Exception\DataMapperException;
use Semiframe\LiquidOrm\DataMapper\Exception\DataMapperInvalidArgumentException;

class DataMapperEnvironmentConfiguration
{
    /**
     * @var array
     */
    private array $credentials =[];

    /**
     * Constructor of the class
     * @param array $credentials
     * @return void
     */
    public function __construct(array $credentials)
    {
        $this->credentials= $credentials;
    }


    /**
     * This function helps to select the database credentials based on the driver or developer chooses
     * @param string $driver
     * @return array
     */
    public function getDatabaseCredentials(string $driver): array
    {
        $connectionArray =[];

        foreach ($this->credentials as $credential){
            if(array_key_exists($driver, $credential)){
                $connectionArray = $credential[$driver];
            }
        }
        return $connectionArray;
    }

    /** Function checks the credentials for validity
     * @param string $driver
     * @return void
     */
    private  function  isCredentialsValid(string $driver): void
    {
        if(empty($driver) && !is_string($driver)){
            throw new DataMapperInvalidArgumentException('Invalid argument. Invalid driver provided');
        }
        if(!is_array($this->credentials)){
            throw new DataMapperInvalidArgumentException('Invalid Credentials');
        }
        if(!in_array($driver, array_keys($this->credentials[$driver]))){
            throw new DataMapperInvalidArgumentException('Invalid or this database driver is not supported');
        }

    }

}