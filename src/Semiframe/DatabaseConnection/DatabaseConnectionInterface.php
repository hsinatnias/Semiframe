<?php

declare(strict_types=1);

namespace Semiframe\DatabaseConnection;

use \PDO;

interface DatabaseConnectionInterface
{
    /**
     * Create new database connection
     * 
     * @return PDO
     */
    public function open(): PDO;

    /**
     * Close database connection
     */

     public function close() : void;
}