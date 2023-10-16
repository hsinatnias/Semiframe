<?php

declare(strict_types=1);

namespace Semiframe\DatabaseConnection\Exception;

use PDOException;

class DatabaseConnectionException extends PDOException
{
    protected $message;
    protected $code;

    public function __construct(string $message = null, $code = null)
    {
        $this->message = $message;
        $this->code = $code;

    }
}